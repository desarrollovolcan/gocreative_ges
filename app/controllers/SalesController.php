<?php

class SalesController extends Controller
{
    private SalesModel $sales;
    private SaleItemsModel $saleItems;
    private ProductsModel $products;
    private ClientsModel $clients;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->sales = new SalesModel($db);
        $this->saleItems = new SaleItemsModel($db);
        $this->products = new ProductsModel($db);
        $this->clients = new ClientsModel($db);
    }

    private function requireCompany(): int
    {
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        return (int)$companyId;
    }

    public function index(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $sales = $this->sales->listWithRelations($companyId);

        $this->render('sales/index', [
            'title' => 'Ventas',
            'pageTitle' => 'Ventas de productos',
            'sales' => $sales,
        ]);
    }

    public function create(): void
    {
        $this->renderForm(false);
    }

    public function pos(): void
    {
        $this->renderForm(true);
    }

    private function renderForm(bool $isPos): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $products = $this->products->active($companyId);
        $clients = $this->clients->active($companyId);

        $this->render('sales/create', [
            'title' => $isPos ? 'Punto de venta' : 'Registrar venta',
            'pageTitle' => $isPos ? 'Punto de venta' : 'Registrar venta',
            'products' => $products,
            'clients' => $clients,
            'today' => date('Y-m-d'),
            'isPos' => $isPos,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $clientId = (int)($_POST['client_id'] ?? 0);
        $client = null;
        if ($clientId > 0) {
            $client = $this->db->fetch(
                'SELECT id FROM clients WHERE id = :id AND company_id = :company_id',
                ['id' => $clientId, 'company_id' => $companyId]
            );
            if (!$client) {
                flash('error', 'Cliente no válido para esta empresa.');
                $this->redirect('index.php?route=sales/create');
            }
        }

        $isPos = ($_POST['channel'] ?? '') === 'pos';
        $items = $this->collectItems($companyId, $isPos);
        if (empty($items)) {
            flash('error', 'Agrega al menos un producto a la venta.');
            $this->redirect($isPos ? 'index.php?route=pos' : 'index.php?route=sales/create');
        }

        $prefix = $isPos ? 'POS-' : 'VEN-';
        $numero = $this->sales->nextNumber($prefix, $companyId);
        $subtotal = array_sum(array_map(static fn(array $item) => $item['subtotal'], $items));
        $tax = max(0, (float)($_POST['tax'] ?? 0));
        $total = $subtotal + $tax;

        $pdo = $this->db->pdo();
        try {
            $pdo->beginTransaction();
            $saleId = $this->sales->create([
                'company_id' => $companyId,
                'client_id' => $clientId ?: null,
                'channel' => $isPos ? 'pos' : 'venta',
                'numero' => $numero,
                'sale_date' => trim($_POST['sale_date'] ?? date('Y-m-d')),
                'status' => $_POST['status'] ?? 'pagado',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'notes' => trim($_POST['notes'] ?? ''),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            foreach ($items as $item) {
                $this->saleItems->create([
                    'sale_id' => $saleId,
                    'product_id' => $item['product']['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $this->products->adjustStock($item['product']['id'], -$item['quantity']);
            }

            audit($this->db, Auth::user()['id'], 'create', 'sales', $saleId);
            $pdo->commit();
            flash('success', 'Venta registrada correctamente.');
        } catch (Throwable $e) {
            $pdo->rollBack();
            log_message('error', 'Error al registrar venta: ' . $e->getMessage());
            flash('error', 'No pudimos guardar la venta. Revisa los datos e intenta nuevamente.');
        }

        $this->redirect($isPos ? 'index.php?route=pos' : 'index.php?route=sales');
    }

    public function show(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $id = (int)($_GET['id'] ?? 0);
        $sale = $this->sales->findForCompany($id, $companyId);
        if (!$sale) {
            $this->redirect('index.php?route=sales');
        }

        $items = $this->db->fetchAll(
            'SELECT si.*, p.name AS product_name, p.sku
             FROM sale_items si
             LEFT JOIN products p ON si.product_id = p.id
             WHERE si.sale_id = :sale_id
             ORDER BY si.id ASC',
            ['sale_id' => $id]
        );

        $this->render('sales/show', [
            'title' => 'Detalle de venta',
            'pageTitle' => 'Detalle de venta',
            'sale' => $sale,
            'items' => $items,
        ]);
    }

    private function collectItems(int $companyId, bool $isPos): array
    {
        $productIds = $_POST['product_id'] ?? [];
        $quantities = $_POST['quantity'] ?? [];
        $unitPrices = $_POST['unit_price'] ?? [];
        $items = [];

        foreach ($productIds as $index => $productId) {
            $productId = (int)$productId;
            $quantity = max(0, (int)($quantities[$index] ?? 0));
            $unitPrice = max(0.0, (float)($unitPrices[$index] ?? 0));
            if ($productId <= 0 || $quantity <= 0) {
                continue;
            }
            $product = $this->products->findForCompany($productId, $companyId);
            if (!$product) {
                continue;
            }
            if ((int)$product['stock'] < $quantity) {
                flash('error', sprintf('Stock insuficiente para %s. Disponible: %d', $product['name'], (int)$product['stock']));
                $this->redirect($isPos ? 'index.php?route=pos' : 'index.php?route=sales/create');
            }
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'unit_price' => $unitPrice > 0 ? $unitPrice : (float)($product['price'] ?? 0),
                'subtotal' => $quantity * ($unitPrice > 0 ? $unitPrice : (float)($product['price'] ?? 0)),
            ];
        }

        return $items;
    }
}

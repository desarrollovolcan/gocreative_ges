<!-- Vendor js -->
<script src="assets/js/vendors.min.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

<script>
    const chatNotificationBadge = document.getElementById('chatNotificationBadge');
    const chatNotificationButton = document.getElementById('chatNotificationButton');
    if (chatNotificationBadge) {
        const storageKey = 'adminChatLastSeen';
        const updateChatNotification = async () => {
            const response = await fetch('index.php?route=chat/notifications');
            if (!response.ok) {
                return;
            }
            const payload = await response.json();
            const latestId = Number(payload.latest_id || 0);
            const lastSeen = Number(localStorage.getItem(storageKey) || 0);
            chatNotificationBadge.dataset.latestId = String(latestId);
            if (latestId > lastSeen) {
                chatNotificationBadge.classList.remove('d-none');
            }
        };

        if (chatNotificationButton) {
            chatNotificationButton.addEventListener('click', () => {
                const latest = Number(chatNotificationBadge.dataset.latestId || 0);
                if (latest) {
                    localStorage.setItem(storageKey, String(latest));
                }
                chatNotificationBadge.classList.add('d-none');
            });
        }

        updateChatNotification();
        setInterval(updateChatNotification, 10000);
    }
</script>

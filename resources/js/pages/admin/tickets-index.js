import echo from '../../echo';

(function () {
    const statusEl = document.getElementById('realtime-status');
    const tbody = document.getElementById('tickets-tbody');

    if (! statusEl || ! tbody) {
        return;
    }

    function createCell(value) {
        const td = document.createElement('td');

        td.className = 'border p-2';
        td.textContent = String(value);

        return td;
    }

    function addTicketRow(ticket) {
        const existingRow = document.querySelector(
            `[data-ticket-id="${ticket.id}"]`
        );

        if (existingRow) {
            return;
        }

        const emptyRow = document.getElementById('tickets-empty-row');
        
        if (emptyRow) {
            emptyRow.remove();
        }

        const tr = document.createElement('tr');

        tr.dataset.ticketId = ticket.id;
        tr.className = 'bg-green-50';

        tr.append(
            createCell(ticket.id),
            createCell(ticket.subject),
            createCell(ticket.user?.name ?? 'User'),
            createCell(ticket.status ?? 'Not set'),
            createCell(ticket.priority ?? 'Not set'),
            createCell(ticket.created_at ?? 'Just now'),
        );

        const actionCell = createCell('');
        const link = document.createElement('a');

        link.href = ticket.url;
        link.className = 'text-blue-600';
        link.textContent = 'View';

        actionCell.append(link);
        tr.append(actionCell);

        tbody.prepend(tr);

        statusEl.textContent = 'New ticket received (realtime)';
        statusEl.className = 'mt-2 text-sm text-green-700';
    }

    echo.private('admins')
        .listen('.ticket.created', function (event) {
            addTicketRow(event);
        })
        .error(function (error) {
            console.error('Admin channel subscription failed:', error);

            statusEl.textContent = 'Realtime connection failed';
            statusEl.className = 'mt-2 text-sm text-red-700';
        });

    statusEl.textContent = 'Realtime listener ready';
    statusEl.className = 'mt-2 text-sm text-green-700';
})();

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Stream com PHP e JS</title>
    <!-- CDN do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }

        .progress-bar-container {
            margin-top: 10px;
        }

        .type {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1>Sistema de EventStream</h1>
        <div id="events" class="mt-3">
            <!-- Barra de progresso inicial -->
            <div id="progress-bar-container" class="progress-bar-container mb-3">
                <div class="progress">
                    <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const eventSource = new EventSource('sse.php');
        const progressBar = document.getElementById('progress-bar');

        function updateProgressBarColor(percentage) {
            if (percentage <= 30) {
                progressBar.classList.remove('bg-warning', 'bg-info', 'bg-success');
                progressBar.classList.add('bg-danger');
            } else if (percentage <= 50) {
                progressBar.classList.remove('bg-danger', 'bg-info', 'bg-success');
                progressBar.classList.add('bg-warning');
            } else if (percentage <= 80) {
                progressBar.classList.remove('bg-danger', 'bg-warning', 'bg-success');
                progressBar.classList.add('bg-info');
            } else {
                progressBar.classList.remove('bg-danger', 'bg-warning', 'bg-info');
                progressBar.classList.add('bg-success');
            }
        }

        eventSource.addEventListener('open', () => {
            const element = document.createElement('div');
            element.classList.add('alert', 'alert-info');
            element.setAttribute('role', 'alert');
            element.innerHTML = 'Conexão estabelecida com o servidor.';
            document.getElementById('events').appendChild(element);
        });

        eventSource.addEventListener('message', event => {
            const data = JSON.parse(event.data);
            const element = document.createElement('div');
            element.classList.add('alert', 'alert-secondary');
            element.setAttribute('role', 'alert');
            element.innerHTML = `Mensagem: ${data.message}`;
            document.getElementById('events').appendChild(element);
        });

        eventSource.addEventListener('progress', event => {
            const data = JSON.parse(event.data);
            const percentage = data.percentage;

            progressBar.style.width = `${percentage}%`;
            progressBar.setAttribute('aria-valuenow', percentage);
            progressBar.innerHTML = `${percentage}%`;

            updateProgressBarColor(percentage);
        });

        eventSource.addEventListener('close', () => {
            const element = document.createElement('div');
            element.classList.add('alert', 'alert-warning');
            element.setAttribute('role', 'alert');
            element.innerHTML = `Conexão encerrada pelo servidor.`;
            document.getElementById('events').appendChild(element);

            eventSource.close();
        });
    </script>

    <!-- CDN do Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!-- Footer -->
    <footer>
        <div class="container">
            <p style="text-align: center; color: var(--text-muted); padding: 3rem 0; border-top: 1px solid var(--border-color); font-size: 0.9rem;">
                &copy; <?= date('Y') ?> JVDeveloper. Todos los derechos reservados.
            </p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formContacto');

            if (form) {
                form.addEventListener('submit', function(event) {
                    const nombre = document.getElementById('nombre').value.trim();
                    const email = document.getElementById('email').value.trim();
                    const mensaje = document.getElementById('mensaje').value.trim();

                    if (nombre === '' || email === '' || mensaje === '') {
                        event.preventDefault();
                        alert('Por favor, completa todos los campos requeridos.');
                    }
                });
            }
        });
    </script>
</body>
</html>
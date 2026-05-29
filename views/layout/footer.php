        </main>
        <footer>
            <p>Sistema de Gestion de Usuarios - PHP + MySQL + MVC</p>
        </footer>
    </div>
</body>
</html>

<?php
if (isset($_SESSION['mensaje'])) {
    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo_mensaje']);
}
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>
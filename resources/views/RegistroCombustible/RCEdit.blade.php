
<body class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center">Registro de Combustible</h2>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <
                <div class="mb-3">
                    <label class="form-label">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control"  required>
                </div>
                
                <div class="mb-3">
                <label>Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control"  required>
                </div>

                <div class="mb-3">
                <label>Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" pattern="[A-Za-z0-9 ]+"  required>
                </div>
                
                <div class="mb-3">
                <label>Marca:</label>
                <input type="text"  id="marca" name="marca" class="form-control"  required>
                </div>

                <div class="mb-3">
                <label>Asignado:</label>
                <input type="text" nid="asignado" ame="asignado" class="form-control"  required>
                </div>

                <div class="mb-3">
                <label>N de factura:</label>
                <input type="number" id="engalones" name="engalones" class="form-control"  step="0.01"  requered>

                </div>
            
                <div class="mb-3">
                    <label class="form-label">Entrada :</label>
                    <input type="number" id="engalones" name="engalones" class="form-control" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Salida :</label>
                    <input type="number" id="sagalones" name="sagalones" class="form-control" step="0.01"  required >
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Precio por galon:</label>
                    <input type="number" id="precio" name="precio" class="form-control" step="0.01" required >
                </div>
                
                <button type="submit" class="btn btn-success w-100">Guardar Registro</button>
            </form>
        </div>
    </div>
</body>
</html>

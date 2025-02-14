
<body class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center">Registro de Vehiculo</h2>
        </div>
        <div class="card-body">
            <form method="post" action="">
                
                <div class="mb-3">
                <label>Equipo:</label>
                <input type="text"  id="equipo" name="equipo" class="form-control"  required>

                <div class="mb-3">
                <label>Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" pattern="[A-Za-z0-9 ]+"  required>
                </div>
                
                <div class="mb-3">
                <label>Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control"  required>
                </div>

                <div class="mb-3">
                <label>Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control"  required>
                </div>

                <div class="mb-3">
                <label>Motor:</label>
                <input type="text"  id="motor" name="motor" class="form-control"   required >

                </div>
            
                <div class="mb-3">
                    <label class="form-label">Serie:</label>
                    <input type="text" id="serie" name="serie" class="form-control" >
                </div>

                <div class="mb-3">
                    <label class="form-label">Asignado:</label>
                    <input type="text"  id="asignado" name="sagalones" class="form-control"  required >
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Observaciones:</label>
                    <input type="text"  id="obs" name="obs" class="form-control" required >
                </div>
               
                <button type="submit" class="btn btn-success w-100">Guardar Registro</button>
            </form>
        </div>
<div class="table-responsive">
    <table class="table" id="myTable3">
        <thead>
            <tr>
                <th scope="col">ID CLIENTE</th>
                <th scope="col">NOMBRE</th>              
            </tr>
        </thead>
        <tbody>

            <?php

            $con = conecta();
            $sql = "SELECT * FROM `clientes`";

            if (mysqli_connect_errno()) {
                echo mysqli_connect_error();
            }
            $result = $con->query($sql);
            if ($result) {

                while ($row = $result->fetch_assoc()) {
            ?>

                    <tr>
                        <td><?php echo $row["id_cliente"]; ?></td>
                        <td> <?php echo $row["nombre"] . ' ' . $row["apellido"]; ?></td>
                    </tr>

            <?php
                }
                $result->close();
                $con->next_result();
            }
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario consulto lista de clientes','$date')";
            $result = $con->query($sql);
            $con->close();
            ?>

        </tbody>
    </table>
</div>
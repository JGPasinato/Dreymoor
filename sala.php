<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Salas de reunião</h1>


    </header>

        <form action="" method="post">
            <select name="sala" id="sala" onchange="atualizarMaxParticipantes()">
                <option value="0">Selecione uma sala</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <br>
            <label for="participantes">Quantidade de participantes</label>
            <input type="number" name="participantes" id="participantes" min="1" max="6" required>

            <br>
            <label for="name">nome</label>
            <input type="text" name="name" id="name" required>
            <br>
            <label for="area">área</label>
            <select name="area" id="area">
                <option value="logistica">logistica</option>
                <option value="Comercial">Comercial</option>
                <option value="Faturamento">Faturamento</option>
                <option value="Financeiro">Financeiro</option>
                <option value="RH">RH</option>
                <option value="TI">TI</option>
                <option value="Diretoria">Diretoria</option>
            </select>
            <br>
        
            
            <label for="data">dia</label>
            <input type="date" name="data" id="inicio" min="2025-01-01" max="2025-12-31" required>
            <br>
            <label for="horainicio">inicio</label>
            <input type="time" name="horainicio" id="horainicio" min="08:00" max="18:00" onkeydown="return false;" required>
            <label for="horafim">fim</label> 
            <input type="time" name="horafim" id="horafim" min="08:00" max="18:00" onkeydown="return false;" required>
            
            <br>
            <label for="cafe">Café</label>
            <label for="cafesim">Sim</label>
            <input type="radio" name="cafe" value="sim" id="cafesim" required>
            <label for="cafenão">Não</label>
            <input type="radio" name="cafe" value="não" id="cafenao" required>
            <br>
            <label for="link">link da reunião</label>
            <input type="text" name="link" id="link">
            <br>
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description">
            <br>
            
            
            <button type="submit">enviar</button>
        </form>

       


    <?php 

        include("conexao.php");

        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
           
            $sala = $_POST['sala'];
            $participantes = $_POST['participantes'];
            $name = $_POST['name'];
            $area = $_POST['area'];
            $data = $_POST['data'];
            $horainicio = $_POST['horainicio'];
            $horafim = $_POST['horafim'];
            $cafe = $_POST['cafe'];
            $link = $_POST['link'];
            $description = $_POST['description'];

           

            $sql = "INSERT INTO reunioes (
                sala, participantes, nome, area, data_reuniao, hora_inicio, hora_fim, cafe, link, descricao
            ) VALUES (
                '$sala', '$participantes', '$name', '$area', '$data', '$horainicio', '$horafim', '$cafe', '$link', '$description'
            )";
    
            if ($mysql->query($sql)) {
                echo "Reunião registrada com sucesso!";
            } else {
                echo "Erro: " . $mysql->error;
            }

           
            


        
        }

        echo "<h2>Reuniões agendadas:</h2>";
        
        $sql = "SELECT * FROM reunioes ORDER BY data_reuniao";
        $resultado = $mysql->query($sql);

        
        
                        echo "<table border='1' cellpadding='8' cellspacing='0'>";
                echo "<thead>
                        <tr>
                            <th>Data</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Sala</th>
                            <th>Participantes</th>
                            <th>Café</th>
                            <th>Link</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>";
                echo "<tbody>";

                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['data_reuniao'] . "</td>";
                    echo "<td>" . $row['hora_inicio'] . "</td>";
                    echo "<td>" . $row['hora_fim'] . "</td>";
                    echo "<td>" . $row['sala'] . "</td>";
                    echo "<td>" . $row['participantes'] . "</td>";
                    echo "<td>" . $row['cafe'] . "</td>";
                    echo "<td>" . $row['link'] . "</td>";
                    echo "<td>" . $row['descricao'] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";

                    

                        if ($resultado->num_rows > 0) {
                            echo "⚠️ Essa sala já está ocupada nesse horário!";
                        } else {
                            // pode fazer o INSERT aqui
                        }



    



    
    ?>
<script>
    function atualizarMaxParticipantes() {
        const sala = document.getElementById("sala").value;
        const participantes = document.getElementById("participantes");

        if (sala == "1") {
            participantes.max = 6;
        } else if (sala == "2") {
            participantes.max = 10;
        }
    }
    document.getElementById("horainicio").addEventListener("change", function () {
    const horaInicio = this.value;
    const horaFim = document.getElementById("horafim");
    horaFim.min = horaInicio; // impede que o horário final seja menor que o inicial
});
</script>


</body>
</html>
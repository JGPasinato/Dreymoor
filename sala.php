<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <img src="./img/Dreymoor.jpg" alt="img" class="logo">
</head>
<body>
    <header>
        <h1>Salas de reunião</h1>


    </header>

        <form action="" method="post" class="formulario">
            <div class="opcsala">
                <select name="sala" id="sala" onchange="atualizarMaxParticipantes()">
                    <option value="0">Selecione uma sala</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <br>
            <div class="participantes">
                <label for="participantes">Quantidade de participantes</label>
                <input type="number" name="participantes" id="participantes" min="1" max="6" required>
            </div>
            <br>
            <div class="nome">
                <label for="name">nome</label>
                <input type="text" name="name" id="name" required>
            </div>
            <br>
            <div class="area">
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
            </div>
            <br>
            
            <div class="data">

                <label for="data">dia</label>
                <input type="date" name="data" id="inicio" min="2025-01-01" max="2025-12-31" required>

            </div>

            <br>
            
            <div class="horario">
                <label for="horainicio">inicio</label>
                <input type="time" name="horainicio" id="horainicio" min="08:00" max="18:00" onkeydown="return false;" required>
                <label for="horafim">fim</label> 
                <input type="time" name="horafim" id="horafim" min="08:00" max="18:00" onkeydown="return false;" required>
            </div>

            <br>

            <div class="cafe">
                <label for="cafe">Café</label>
                <label for="cafesim">Sim</label>
                <input type="radio" name="cafe" value="sim" id="cafesim" required>
                <label for="cafenão">Não</label>
                <input type="radio" name="cafe" value="não" id="cafenao" required>
            </div>

            <br>

            <div class="link">
                <label for="link">link da reunião</label>
                <input type="link" name="link" id="link">
            </div>

            <br>
                
            <div class="descricao">
                <label for="description">Descrição</label>
                <input type="text" name="description" id="description">
            </div>

            <br>
            
            <div class="btn">
                <button type="submit">enviar</button>
            </div>
                
        </form>

       


    <?php 

        include("conexao.php");


        if (isset($_POST['id_para_deletar'])) {
            $id = $_POST['id_para_deletar'];
            $mysql->query("DELETE FROM reunioes WHERE id = $id");
        }
        
        

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['id_para_deletar'])) {
           
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

           

            $verificar = "SELECT * FROM reunioes 
            WHERE sala = '$sala' 
            AND data_reuniao = '$data' 
            AND ('$horainicio' < hora_fim AND '$horafim' > hora_inicio)";
        
            $verificacao = $mysql->query($verificar);
            
            if ($verificacao->num_rows > 0) {
                echo "⚠️ Essa sala já está ocupada nesse horário!";
            } else {
                $sql = "INSERT INTO reunioes (
                    sala, participantes, nome, area, data_reuniao, hora_inicio, hora_fim, cafe, link, descricao
                ) VALUES (
                    '$sala', '$participantes', '$name', '$area', '$data', '$horainicio', '$horafim', '$cafe', '$link', '$description'
                )";
            
                if ($mysql->query($sql)) {
                    echo "✅ Reunião registrada com sucesso!";
                } else {
                    echo "Erro: " . $mysql->error;
                }
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
                    echo "<td><a href='" . $row['link'] . "' target='_blank'>🔗</a></td>";
                    echo "<td>" . $row['descricao'] . "</td>";
                    echo "<td>
                            <form method='post'>
                                <input type='hidden' name='id_para_deletar' value='" . $row['id'] . "'>
                                <button type='submit'>🗑️</button>
                            </form>
                        </td>";

                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";

                    
              
                       



    



    
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
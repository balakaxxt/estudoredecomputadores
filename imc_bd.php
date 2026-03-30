<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "imc_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$resultado = null;

// PROCESSA SOMENTE QUANDO ENVIA
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imc = $_POST["imc"];

    if ($imc < 16) {
        $resultado = "Magreza Grau III";
    } elseif ($imc <= 16.9) {
        $resultado = "Magreza Grau II";
    } elseif ($imc <= 18.4) {
        $resultado = "Magreza Grau I";
    } elseif ($imc <= 24.9) {
        $resultado = "Eutrofia";
    } elseif ($imc <= 29.9) {
        $resultado = "Pré-Obesidade";
    } elseif ($imc <= 34.9) {
        $resultado = "Obesidade Moderada (Grau I)";
    } elseif ($imc <= 39.9) {
        $resultado = "Obesidade Severa (Grau II)";
    } else {
        $resultado = "Obesidade Muito Severa (Grau III)";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="https://cdn-icons-png.flaticon.com/512/2964/2964514.png">
<meta charset="UTF-8">
<title>Tabela IMC</title>

<style>
body{
    margin:0;
    font-family: Arial;
    background:#0f0f0f;
    color:white;

    display:flex;
    flex-direction:column;
    align-items:center;
}

h2{
    margin-top:20px;
    color:#00bfff;
}

/* RESULTADO SIMPLES (SEM LUZ) */
.resultado{
    margin:15px;
    padding:10px 20px;
    font-size:26px;
    border-radius:8px;
    background:#222;
}

/* TABELA COM EFEITO NEON */
table{
    margin:20px;
    font-size:20px;
    border-collapse:collapse;
    background:#111;

    box-shadow: 0 0 10px #00bfff,
                0 0 20px #00bfff,
                0 0 40px #00bfff;
}

th, td{
    border:1px solid #555;
    padding:10px;
}

th{
    background:#00bfff;
    color:black;
}

/* FORM FLEX */
.form-box{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:10px;
}

/* INPUT GRANDE */
input[type="number"]{
    width:300px;
    height:50px;
    font-size:22px;
    border-radius:8px;
    border:none;
    text-align:center;
}

/* BOTÃO COM HOVER */
input[type="submit"]{
    width:200px;
    height:50px;
    font-size:20px;
    border:none;
    border-radius:8px;
    background:#00bfff;
    color:black;
    cursor:pointer;
    transition:0.3s;
}

input[type="submit"]:hover{
    background:#00ffcc;
    box-shadow:0 0 10px #00ffcc,
               0 0 20px #00ffcc;
    transform:scale(1.05);
}
</style>
</head>

<body>

<h2>Tabela de IMC</h2>

<!-- RESULTADO SÓ APARECE SE EXISTIR -->
<?php
if ($resultado !== null) {
    echo "<div class='resultado'>Resultado: $resultado</div>";
}
?>

<table>
<tr>
    <th>IMC (kg/m²)</th>
    <th>Classificação</th>
</tr>

<?php
$sql = "SELECT * FROM classificacao_imc";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["faixa"] . "</td>";
    echo "<td>" . $row["classificacao"] . "</td>";
    echo "</tr>";
}
?>
</table>

<div class="form-box">
<form method="post">
    <p>Digite o IMC</p>
    <input type="number" step="0.1" name="imc" required>
    <input type="submit" value="Verificar">
</form>
</div>

<script>
let text = "Calculadora de IMC Online – Rápido e Grátis ";
let i = 0;

setInterval(() => {
  document.title = text.slice(i) + text.slice(0, i);
  i = (i + 1) % text.length;
}, 200);
</script>

</body>
</html>
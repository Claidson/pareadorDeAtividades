
    <?php

try {
    $conexao = new PDO("pgsql:host=localhost; dbname=pareador", "postgres", "postgres");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "Erro na conexão:" . $erro->getMessage();
}
?>

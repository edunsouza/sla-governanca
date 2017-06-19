<?php
class ConexaoBanco {

    private static $host = 'localhost';
    private static $user = 'root';
    private static $password = '';
    private static $db = 'SLA_GTI';

    public static function query($sql) {
        // Estabelece conexão e prepara charset correto
        $connexao = new mysqli(self::$host, self::$user, self::$password, self::$db);
        $connexao->set_charset("utf8");

        // Executa query
        $resultSet = $connexao->query($sql, MYSQLI_USE_RESULT);

        if ($resultSet) {
            $rows = [];

            while($row = @$resultSet->fetch_assoc()) {
                $rows[] = $row;
            }

            $resultSet->close();
            $connexao->close();
            return $rows;
        }

        return false;
    }
    
}
?>
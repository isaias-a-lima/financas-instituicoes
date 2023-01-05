<?php
namespace app\model\dao;

use app\lib\Constantes;
use app\model\entities\converter\UsuarioConverter;

require_once Constantes::DEFAULT_MODEL_DIR . "/dao/Conexao.php";
require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/UsuarioConverter.php";

use Exception;
use PDO;

class LoginDao {

    private Conexao $conexao;

    public function __construct() {
        $this->conexao = new Conexao();        
    }

    public function getUsuarioByEmail($email) {
        $conn = $this->conexao->getConn();
        $result = false;
        $db = "financas_instituicoes";
        $sql = "SELECT * FROM $db.usuarios u, $db.usersecurity1 s WHERE u.email = :email";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $result = UsuarioConverter::ArrayToUsuario($result[0]);
            }
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }finally {
            $conn = null;
        }
        return $result;
    }

}
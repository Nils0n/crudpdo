<?php
class Pessoa
{

    private $pdo;

    public function __construct($dbname, $host, $user, $password)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $password);
        } catch (PDOException $e) {
            echo "Erro com banco de dados: " . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo "Erro genêrico: " . $e->getMessage();
            exit();
        }
    }

    public function getDate()
    {
        $dates = array();
        $date = $this->pdo->query("SELECT * FROM pessoa ORDER BY id DESC");
        $dates = $date->fetchAll(PDO::FETCH_ASSOC);

        return $dates;
    }

    public function registerPessoa($name, $telephone, $email)
    {
        $date = $this->pdo->prepare("SELECT id FROM pessoa WHERE email=:e");
        $date->bindValue(":e", $email);
        $date->execute();
        if ($date->rowCount() > 0) {
            return false;

        } else {
            $date = $this->pdo->prepare("INSERT INTO pessoa (nome , telefone, email) VALUES(:n ,:t , :e)");
            $date->bindValue(":n", $name);
            $date->bindValue(":t", $telephone);
            $date->bindValue(":e", $email);
            $date->execute();

            return true;
        }
    }

    public function deletePessoa($id)
    {
        $date = $this->pdo->prepare("DELETE FROM pessoa WHERE id =:id");
        $date->bindValue(":id", $id);
        $date->execute();
    }

    public function getDatePessoa($id)
    {

        $datePessoa = array();
        $date = $this->pdo->prepare("SELECT nome, telefone, email FROM pessoa WHERE id=:id");
        $date->bindValue(":id", $id);
        $date->execute();
        $datePessoa = $date->fetch(PDO::FETCH_ASSOC);

        return $datePessoa;
    }

    public function setPessoa($id, $name, $telephone, $email)
    {
        $date = $this->pdo->prepare("UPDATE pessoa SET nome= :n , telefone= :t , email= :e WHERE id= :id");
        $date->bindValue(":id", $id);
        $date->bindValue(":n", $name);
        $date->bindValue(":t", $telephone);
        $date->bindValue(":e", $email);
        $date->execute();

    }
}

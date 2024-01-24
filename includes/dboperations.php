<?php

class DbOperation
{

    private $conn;

    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/config.php';
        require_once dirname(__FILE__) . '/connect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    //Function to create a new user
    public function createUser($email, $name, $password, $admin)
    {

        $sql = "SELECT * FROM `users` WHERE `user_email`='$email'";
        $query = mysqli_query($this->conn, $sql);
        $row_num = mysqli_num_rows($query);
        if($row_num != 0){
            $responsestring = "Email already exists";
            return $responsestring;
        }
        else{
            $stmt = $this->conn->prepare("INSERT INTO users(user_email, user_name, user_password, admin) values(?, ?, ?, ?)");
            $stmt->bind_param("sssi", $email, $name, $password, $admin);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getUser($name, $password)
    {
        $sql = "SELECT * FROM `users` WHERE `user_name`='$name' AND `user_password`='$password'";
        $query = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_assoc($query);
        $resultid = $result['user_id'];
        $row_num = mysqli_num_rows($query);
        if ($row_num != 0) {
            return $resultid;
        } else {
            return false;
        }
    }


    public function getArtigos()
    {
        $sql = "SELECT * FROM `track`";
        $query = mysqli_query($this->conn, $sql);
        $data = array();
        $row_num = mysqli_num_rows($query);
        $i = 1;
        echo("[");
        while($row = mysqli_fetch_assoc($query)){
            $data = $row;
            echo json_encode($row);
            if($i != $row_num){
                echo(",");
            }
            $i++;
        }
        echo("]");
        return $data;
    }

    public function getHorario()
    {
        $sql = "SELECT * FROM `horario`";
        $query = mysqli_query($this->conn, $sql);
        $data = array();
        $row_num = mysqli_num_rows($query);
        $i = 1;
        echo("[");
        while($row = mysqli_fetch_assoc($query)){
            $data = $row;
            echo json_encode($row);
            if($i != $row_num){
                echo(",");
            }
            $i++;
        }
        echo("]");
        return $data;
    }

    public function getUserbyID($ID){
        $sql = "SELECT * FROM `users` WHERE `user_id`='$ID'";
        $query = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_assoc($query);
        return $result;
    }

    public function deleteTrack($nome, $texto){

        $sql2 = "SELECT * FROM `track` WHERE `nome`='$nome' AND `texto`='$texto'";
        $query2 = mysqli_query($this->conn, $sql2);
        $row_num = mysqli_num_rows($query2);
        echo($row_num);
        if($row_num == 0){
            return false;
        }
        else{
            $sql = "DELETE FROM `track` WHERE `nome`='$nome' AND `texto`='$texto'";
            $query = mysqli_query($this->conn, $sql);

            return true;
        } 
        
    } 

    public function updateUser($changeID, $email, $name, $password){
        $sql = "UPDATE `users` SET `user_email`='$email', `user_name`='$name', `user_password`='$password' WHERE `user_id`='$changeID'";        $query = mysqli_query($this->conn, $sql);
        $query = mysqli_query($this->conn, $sql);
        if($query){
            return true;
        }
        else{
            return false;
        }
    }


    public function createTrack($nome, $texto, $titulo, $autores, $descricao, $sala, $data, $hora, $escolhido){
        $stmt = $this->conn->prepare("INSERT INTO track(nome, texto, ficheiro) values(?, ?, ?)");
        $stmt->bind_param("ssb", $nome, $texto, $escolhido);
        $result = $stmt->execute();
        $stmt->close();
        echo($result);
        if ($result) {
            
            $sql = "SELECT * FROM `track` WHERE `nome`='$nome' AND `texto`='$texto'";
            $query = mysqli_query($this->conn, $sql);
            $resultselect = mysqli_fetch_assoc($query);
            $idtrack = $resultselect['id'];

            $stmt2 = $this->conn->prepare("INSERT INTO artigo(titulo, autores, descricao, idTrack) values(?, ?, ?, ?)");
            $stmt2->bind_param("sssi", $titulo, $autores, $descricao, $idtrack);
            $result2 = $stmt2->execute();
            $stmt2->close();
            echo($result2);
            if($result2){
                $sql2 = "SELECT * FROM `artigo` WHERE `titulo`='$titulo' AND `autores`='$autores' AND `descricao`='$descricao' AND `idTrack`='$idtrack'";
                $query2 = mysqli_query($this->conn, $sql2);
                $resultselect2 = mysqli_fetch_assoc($query2);
                $idartigo = $resultselect2['id'];

                $stmt3 = $this->conn->prepare("INSERT INTO horario(idArtigo, idTrack, sala, data, hora) values(?, ?, ?, ?, ?)");
                $stmt3->bind_param("iisss", $idartigo, $idtrack, $sala, $data, $hora);
                print_r($stmt3);
                $result3 = $stmt3->execute();
                $stmt3->close();
                echo($result3);
                if($result3){
                    return true;
                }
                else{
                    return false;
                }

            }
            else{
                return false;
            }

        } else {
            return false;
        }
    }

    public function updateTrack($ID, $nome, $texto, $titulo, $autores, $descricao, $sala, $data, $hora){
        $stmt = "UPDATE track SET `nome`='$nome', `texto`='$texto' WHERE `id`='$ID'";
        $result = mysqli_query($this->conn, $stmt);
        if ($result) {
            $sql = "SELECT * FROM `track` WHERE `id`='$ID'";
            $query = mysqli_query($this->conn, $sql);
            $resultselect = mysqli_fetch_assoc($query);
            $idtrack = $resultselect['id'];
            
            $stmt2 = "UPDATE artigo SET `titulo`='$titulo', `autores`='$autores', `descricao`='$descricao' WHERE `idTrack`='$ID'";
            $result2 = mysqli_query($this->conn, $stmt2);
            if($result2){
                $sql2 = "SELECT * FROM `artigo` WHERE `idTrack`='$ID'";
                $query2 = mysqli_query($this->conn, $sql2);
                $resultselect2 = mysqli_fetch_assoc($query2);
                $idartigo = $resultselect2['id'];


                $stmt3 = "UPDATE horario SET `idArtigo`='$idartigo', `idTrack`='$idtrack', `sala`='$sala', `data`='$data', `hora`='$hora' WHERE `idTrack`='$ID'";
                $result3 = mysqli_query($this->conn, $stmt3);
                if($result3){
                    return true;
                }
                else{
                    return false;
                }

            }
            else{
                return false;
            }

        } else {
            return false;
        }
    }

    public function getTrackbyID($ID){
        $sql = "SELECT * FROM `track` WHERE `id`='$ID'";
        $query = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_assoc($query);

        $sql2 = "SELECT * FROM `artigo` WHERE `idTrack`='$ID'";
        $query2 = mysqli_query($this->conn, $sql2);
        $result2 = mysqli_fetch_assoc($query2);

        $sql3 = "SELECT * FROM `horario` WHERE `idTrack`='$ID'";
        $query3 = mysqli_query($this->conn, $sql3);
        $result3 = mysqli_fetch_assoc($query3);

        $sql4 = "SELECT `empresa` FROM `presenca` WHERE `idTrack`='$ID'";
        $query4 = mysqli_query($this->conn, $sql4);
        $result4 = mysqli_fetch_assoc($query4);

        if($result4 != NULL){
            $masterresult = $result + $result2 + $result3 + $result4;
        }
        else {
            $masterresult = $result + $result2 + $result3;
        }
        

        return $masterresult;
    }

    public function createPresenca($nome,$empresa,$email,$contacto,$data,$idTrack)
    {
        $stmt = $this->conn->prepare("INSERT INTO presenca(nome, empresa, email, contacto, data, idTrack) values(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $nome, $empresa, $email, $contacto, $data, $idTrack);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function createPergunta($nome,$email,$idTrack,$questao)
    {
        $stmt = $this->conn->prepare("INSERT INTO pergunta(nome, email, idTrack, pergunta) values(?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nome, $email, $idTrack, $questao);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getPerguntas()
    {
        $sql = "SELECT * FROM `pergunta`";
        $query = mysqli_query($this->conn, $sql);
        $data = array();
        $row_num = mysqli_num_rows($query);
        $i = 1;
        echo("[");
        while($row = mysqli_fetch_assoc($query)){
            $data = $row;
            echo json_encode($row);
            if($i != $row_num){
                echo(",");
            }
            $i++;
        }
        echo("]");
        return $data;
    }
        
    public function getPerguntabyID($ID){
        $sql = "SELECT * FROM `pergunta` WHERE `id`='$ID'";
        $query = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_assoc($query);
        return $result;
    }
}
?>
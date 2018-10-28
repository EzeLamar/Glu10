<?php
class Usuario{

    // variable de conexion con la base de datos y nombre de la tabla
    private $conn;
    private $table_name = "usuario";

    // atributos IDU, Nombre, Apellido, Edad, Email, Passwd, NroTelefono, esCeliaco
    public $id;
    public $nombre;
    public $apellido;
    public $edad;
    public $email;
    public $password;
    public $nroTel;
    public $esCel;

    // constructor, se le pasa un objeto de tipo database
    public function __construct($db){
        $this->conn = $db;
    }

      // leer usuarios
    function read(){

        //consulta a la base de datos: seleccionar todos los usuarios
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " u";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // insertar un usuario nuevo
    function create($cp,$id){

        // consulta a la base de datos para insertar un registro
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    IDU =:id, nombre =:nombre, apellido =:apellido, edad =:edad, email =:email, password =:password, nroTel =:nroTel, esCel =:esCel";

        // consulta a la base de datos para insertar un registro
        $query2 = "INSERT INTO
                      viveen
                SET
                   CP =:cp, IDU =:id ";


        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // preparar la consulta
        $stmt2= $this->conn->prepare($query2);

        // se pasan los atributos a formato html
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellido=htmlspecialchars(strip_tags($this->apellido));
        $this->edad=htmlspecialchars(strip_tags($this->edad));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->nroTel=htmlspecialchars(strip_tags($this->nroTel));
        $this->esCel=htmlspecialchars(strip_tags($this->esCel));

        // se pasan los atributos a formato html
        $cp=htmlspecialchars(strip_tags($cp));
        $this->id=htmlspecialchars(strip_tags($id));

        // se ligan los valores de parametros
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":edad", $this->edad);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":nroTel", $this->nroTel);
        $stmt->bindParam(":esCel", $this->esCel);

        // se ligan los valores de parametros
        $stmt2->bindParam(":cp", $cp);
        $stmt2->bindParam(":id", $id);

        // ejecutar la consulta: puede fallar o ser exitosa
      if($stmt->execute() && $stmt2->execute()){
            return true;
        }

        return false;

    }


    //funcion de borrado
    function delete(){

        // consulta de eliminacion
        $query = "DELETE FROM " . $this->table_name . " WHERE IDU = ?";
        $query2 ="DELETE FROM viveen WHERE IDU = ?";
        // preparar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        // se pasan los valores a formato html
        $this->id=htmlspecialchars(strip_tags($this->id));


        // se enlaza el parametro de id
        $stmt->bindParam(1, $this->id);
        $stmt2->bindParam(1, $this->id);

        // ejecutar la consulta
      if($stmt2->execute()){
         if($stmt->execute())
              return true;
        }

        return false;

    }

    //consultar por un solo usuario
    function readOne(){

        //conuslta de solo un registro
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " u
                WHERE
                    u.IDU = ?";

        // preparar consulta
        $stmt = $this->conn->prepare( $query );

        // enlazar el id como parametro
        $stmt->bindParam(1, $this->id);

        // ejecutar consulta
        $stmt->execute();

        // obtener la fila
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // setear valores a los atributos
        $this->nombre = $row['nombre'];
        $this->apellido = $row['apellido'];
        $this->edad = $row['edad'];
        $this->email = $row['email'];
        $this->password = $row['password'];
        $this->nroTel = $row['nroTel'];
        $this->esCel = $row['esCel'];
        $this->id = $row['id'];
    }

    // busca productos que empiecen con
    function search($keywords){

        // consulta de seleccion
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " u
                WHERE
                    u.nombre LIKE ? OR u.apellido LIKE ? OR u.email LIKE ?";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // convertir los datos a html y agregar los simbolos para la operacion like
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // enlazar los parametros
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        // ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // actualizar los datos del restaurant
    function update(){

        // consulta de actualizacion
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nombre = :nombre,
                    apellido = :apellido,
                    edad = :edad,
                    password = :password,
                    email = :email,
                    esCel = :esCel,
                    nroTel = :nroTel
                WHERE
                    IDU = :id";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // pasar a formato html
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellido=htmlspecialchars(strip_tags($this->apellido));
        $this->edad=htmlspecialchars(strip_tags($this->edad));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->nroTel=htmlspecialchars(strip_tags($this->nroTel));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->esCel=htmlspecialchars(strip_tags($this->esCel));

        // se enlazan los nuevos valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":edad", $this->edad);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nroTel", $this->nroTel);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":esCel", $this->esCel);
        $stmt->bindParam(":id", $this->id);

        // ejecutar la consulta
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function calificar($IDR,$cs,$a,$p,$h){

      $query = "INSERT INTO
                  califico
              SET
                  IDU =:id,IDR=:IDR,calidadServicio=:cs,atencion=:a,higiene=:h,precio=:p";

      // preparar la consulta
      $stmt = $this->conn->prepare($query);

      // pasar a formato html
      $this->id=htmlspecialchars(strip_tags($this->id));
      $IDR=htmlspecialchars(strip_tags($IDR));
      $cs=htmlspecialchars(strip_tags($cs));
      $a=htmlspecialchars(strip_tags($a));
      $p=htmlspecialchars(strip_tags($p));
      $h=htmlspecialchars(strip_tags($h));

      // se enlazan los nuevos valores
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":IDR", $IDR);
      $stmt->bindParam(":cs", $cs);
      $stmt->bindParam(":a", $a);
      $stmt->bindParam(":p", $p);
      $stmt->bindParam(":h", $h);

      // ejecutar la consulta
      if($stmt->execute()){
          return true;
      }

      return false;
    }
}

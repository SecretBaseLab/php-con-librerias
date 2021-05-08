<?php
class userAccount{
    //atrib
    public $nombre, $saldo, $idUser, $cedula, $tipoCuenta;    
    public function __construct($id){
        $this->idUser = $id + 1;
    }
    // public function __destruct(){ echo "me mori yo tambien XD<br>";}

    //metodos
    public function addAccount($datos){
        list(
            $this->nombre,
            $this->cedula,
            $this->tipoCuenta,
            $this->saldo
        ) = $datos;
    }

    public function listAccounts(){
        echo "
            Cedula: $this->cedula <br>
            Nombre: $this->nombre <br>
            Saldo: $this->saldo <br>
            Tipo Cuenta: $this->tipoCuenta <br>
            ************************<br>
        ";
    }
}

class transaccion extends userAccount{
    //atrib
    public $tipoTransaccion;
    public function __construct(){
        
    }   
    
    //metodos
    public function addTransaccion($datos){
        list(
            $this->tipoTransaccion,
            $_saldo,

        ) = $datos;
        if($this->tipoTransaccion == "deposito")
            $this->saldo = $this->saldo + $_saldo;
        else
            $this->saldo = $this->saldo - $_saldo;
    }

    public function showHistory(){
        $this->listAccounts();
        echo $this->nombre;
    }
}

//ingreso de datos
$datosUsuarios = [
    ['darwin', '0987654321', 'ahorros', 10],
    ['leslie', '9817237191', 'credito', 0],
    ['bel', '0987654321', 'ahorros', 0]
];
$usuarios = array();
foreach ($datosUsuarios as $key => $value) {
    $usuarios[$key] = new userAccount($key);
    $usuarios[$key]->addAccount($value);
}

//mostrar usuarios
foreach ($usuarios as $obj) {
    $obj->listAccounts();
}

//ingresar transaccions 
$datosTransaccions = [
    ["deposito", 8, 0],
    ["retiro", 5, 1],
    ["retiro", 1, 0],
    ["deposito", 1, 2]
];
$transaccionesObjs = array();
$contador = 0;
foreach ($usuarios as $key => $usuario) {
    echo $usuario->saldo;
    foreach ($datosTransaccions as $datos) {
        if($key == $datos[2])
            if($usuario->saldo < $datos[1] && $datos[0] == "retiro")
                echo "Saldo insuficiente para realizar un retiro - usuario: $usuario->nombre <br>";
            else{     
                $transaccionesObjs[$contador] = new transaccion();
                $transaccionesObjs[$contador]->addTransaccion($datos);
                $contador++;    
            }
    }
    echo $usuario->saldo."<br>";
}

foreach ($transaccionesObjs as $key => $value) {
    print_r($value);
    echo "<br>";
}

//mostrar usuarios
foreach ($usuarios as $obj) {
    $obj->listAccounts();
}
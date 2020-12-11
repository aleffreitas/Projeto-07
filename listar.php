<?php

// verifica se o post funcionou
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id');
    $usuario = filter_input(INPUT_POST, 'usuario');
    $senha = filter_input(INPUT_POST, 'senha');
    $sexo = filter_input(INPUT_POST, 'sexo');
    $email = filter_input(INPUT_POST, 'email');
} else if (!isset($id)) {

    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
}

// Cria a conexão com o banco de dados
try {
    $conexao = new PDO("mysql:host=localhost;dbname=exercicio_crud", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "<p class=\"bg-danger\">Falha na conexão com o Bancoe de dados:" . $erro->getMessage() . "</p>";
}


if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $usuario != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE usuario SET usuario=?, senha=?, sexo=?, email=? WHERE id = ?");
            $stmt->bindParam(5, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO usuario (usuario, senha, sexo, email) VALUES (?, ?, ?, ?)");
        }
        $stmt->bindParam(1, $usuario);
        $stmt->bindParam(2, $senha);
        $stmt->bindParam(3, $sexo);
        $stmt->bindParam(4, $email);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                /*echo "<p class=\"bg-success\">Usuario cadastrado com sucesso!</p>";*/
                echo "<script>alert('Usuario cadastrado com sucesso!');</script>";
                $id = null;
                $usuario = null;
                $senha = null;
                $sexo = null;
                $email = null;
                
            } else {
                /*echo "<p class=\"bg-danger\">Erro ao cadastrar</p>";*/
                echo "<script>alert('Erro ao cadastrar');</script>";
            }
        } else {
            /*echo "<p class=\"bg-danger\">Erro: Não foi possível executar o comando sql</p>";*/
            echo "<script>alert('Erro: Não foi possível executar o comando sql');</script>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</p>";
    }
}

//Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $usuario = $rs->usuario;
            $senha = $rs->senha;
            $sexo = $rs->sexo;
            $email = $rs->email;
            
        } else {
            /*echo "<p class=\"bg-danger\">Erro: Não foi possível executar o comando sql</p>";*/
            echo "<script>alert('Erro: Não foi possível executar o comando sql');</script>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</p>";
    }
}

//Delete
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM usuario WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            /*echo "<p class=\"bg-success\">Usuario excluído com êxito</p>";*/
            echo "<script>alert('Usuario excluído com êxito');</script>";
            $id = null;
        } else {
            /*echo "<p class=\"bg-danger\">Erro: Não foi possível executar o comando sql</p>";*/
            echo "<script>alert('Erro: Não foi possível executar o comando sql');</script>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</a>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge" >
        <script src="js/script.js"></script>
        <link href="css/style.css" rel="stylesheet" />       
        
        
    </head>
    <body>
        
            <header >
                <div clas="cabecalho">
                    <h3>
                     Trabalho Web CRUD_PHP  20-11-2020 <br>
                     Nome: Alef Freitas <br>
                     Professor:  Daniel Capanema
                    </h3>
                </div>
                
            </header>
            
            <div class="container">
            <div class="container2">
                <div class="row">
                    <form action="?act=save" method="POST" name="form1" class="form-horizontal" >
                        <div class="panel-panel-default">
                                <div class="panel-heading">
                                    <div class="img"></div>
                                    <h2 id="titulo">Cadastro</h2>
                                    <h3 class="subtitulo">Informações Pessoais</h3>                                    
                                </div>
                                    <input type="hidden" name="id" value="<?php
                                    echo (isset($id) && ($id != null || $id != "")) ? $id : ''; ?>" />
                                    <div class="form-group">
                                        <span id="cod" style="visibility: hidden" required="O campo">O CAMPO USUÁRIO DEVE CONTER NO MÍNIMO 3 CARACTERES</span>
                                            <input type="text" placeholder="*USUÁRIO" name="usuario" id="usuario"  onblur="valida()" value="<?php
                                            echo (isset($usuario) && ($usuario != null || $usuario != "")) ? $usuario : ''; ?>" class="form-control" required/>
                                                                        
                                            <input type="password" placeholder="*SENHA" id="senha"  name="senha" value="<?php
                                            echo (isset($senha) && ($senha != null || $senha != "")) ? $senha : '';?>" class="form-control" required/>                                    
                                    
                                    
                                            <input type="text" placeholder="*SEXO" id="sexo"  name="sexo" value="<?php
                                            echo (isset($sexo) && ($sexo != null || $sexo != "")) ? $sexo : ''; ?>" class="form-control" required/>
                                        
                                            <input type="email" placeholder="*E-MAIL" id="email"  name="email" value="<?php
                                            echo (isset($email) && ($email != null || $email != "")) ? $email : ''; ?>" class="form-control" required/>

                                            <div class="pull-right">
                                                <p>* Campos Obrigatórios</p>
                                                    <button type="submit" class="btn-btn-primary" />Salvar</button>
                                            
                                            </div>
                                    </div>
                        </div>
                    </form>
                </div>
                
            
                
                <div class="row2">
                    <div class="panel-panel-default">
                        <table class="table-table-striped">
                            <thead>
                                <tr>
                                    <th><p>USUÁRIO</p></th>
                                    <th><p>SENHA</p></th>
                                    <th><p>SEXO</p></th>
                                    <th><p>EMAIL</p></th>
                                    <th><p>AÇÕES</p></th>
                                </tr>
                            </thead>
                            <tbody>
                                

                                <?php
                                
                                    try {
                                        $stmt = $conexao->prepare("SELECT * FROM usuario");
                                        if ($stmt->execute()) {
                                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                ?>          
                                            <tr>                                               
                                                    <td><?php echo $rs->usuario; ?></td>
                                                    <td><?php echo $rs->senha; ?></td>
                                                    <td><?php echo $rs->sexo; ?></td>
                                                    <td><?php echo $rs->email; ?></td>
                                                    <td>
                                                        
                                                            <a href="?act=upd&id=<?php echo $rs->id; ?>" class="btn btn-default btn-xs"><img src="\\img\pencil.png" style="width:30px; height:30px; margin-right:25px;"></a>
                                                            <a href="?act=del&id=<?php echo $rs->id; ?>" class="btn btn-danger btn-xs" ><img src="\\img\trash.png" style="width:30px; height:30px;"></a>
                                                        
                                                    </td>                                                
                                            </tr>
                                        <?php
                                    }
                                } else {
                                    echo "Erro: Não foi possível recuperar os dados";
                                }
                            } catch (PDOException $erro) {
                                echo "Erro: " . $erro->getMessage();
                            }

                            ?>


                            </tbody>
                        </table>
                    </div>
                </div>

            </div><!--container2-->
            </div>
        
    </body>
</html>
<div class="login">
    <div class="card">
        <div class="card-header">
            <img calss="imagem" src="img/icone.png" style="width:80px; height:80px;" alt="LaryPets">
        </div>
        <div class="card-body">
            <form method="POST" name="form2"  data-parsley-validate>
                <label for="email">E-mail:</label>
                <input type="email" name="email" class="form-control" placeholder="Digite seu E-mail" required
                    data-parsley-required-message="Preencha este campo"
                    data-parsley-type-message="Digite um e-mail válido">


                <label for="senha">Senha</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha"
                        data-parsley-errors-container="#erro" data-parsley-required-message="Preencha este campo"
                        required data-parsley-type-massage="Digite uma senha">
                    <button class="btn btn-outline-secondary" type="button" onclick="mostrarSenha()"><i
                            class="fas fa-eye"></i></button>
                </div>
                <div id="erro"></div>
                <br>
               
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-check"> Fazer Login</i>
                </button>
            </form>
        </div>
    </div>
</div>
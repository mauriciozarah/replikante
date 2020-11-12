@extends('layouts.template')

@section('content')
	
	<dir class="row justify-content-center mt-5" id="login">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					Login
				</div>
				<div class="card-body">
       	           	<form class="form-horizontal">
	            		<p>
	            			<input type="email" name="email" placeholder="E-mail" class="form-control" maxlength="191" class="form-control" id="email_login"><br>
	            			<small id="error_email"></small>
	            		</p>
	            		<p>
	            			<input type="password" name="password" class="form-control" id="password_login" placeholder="Senha"><br>
	            			<small id="error_password"></small>
	            		</p>
	            		<p>
	            			<button type="button" class="btn-info" onclick="conect();">Logar</button>
	            		</p>
            		</form>
				</div><!-- end card-body -->
			</div><!-- end card -->
		</div><!-- end col-md-6 -->
	</dir><!-- end row -->


	<div class="row justify-content-center mt-5" id="loged" style="display:none;">
		<div class="col-md-10">
			<div class="card">
	            <div class="card-header">Usuários</div>

	            <div class="card-body">
	                <div class="row text-right mt-2 mb-4">
	                    <div class="col-md-9">
	                        <input type="search" name="search" id="txt-search" class="form-control" placeholder="Buscar" onkeyup='getSearchPaginate()' />
	                    </div>
	                    <div class="col-md-3 text-right">
	                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
	                            + Adicionar
	                        </button>
	                    </div>
	                </div>
	                <div class="table-responsive" id="table_data">
	                  <table class="table table-bordered table-dashed table-striped">
	                    <thead class="thead-dark">
	                        <tr>
	                            <th><a href="#" class="anchor-ordenade" onclick="ordem('name')">Nome</a></th>
	                            <th><a href="#" class="anchor-ordenade" onclick="ordem('email')">E-mail</a></th>
	                            <th colspan="2">Açoes</th>
	                        </tr>
	                    </thead>
	                    <tbody id="body">

	                    </tbody>
	                  </table>
	                </div><!-- end table-responsive -->


	            </div><!-- end card -->
	        </div>
        </div><!-- end col-md-10 -->
	</div><!-- end row -->
    


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar Usuários</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reseta()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" style="display:none">Algo deu errado na Gravaçao</div>
        <div class="alert alert-success" style="display:none">Cadastrado com Sucesso</div>
        <form class="form form-vertical">
            <div>
                <input type="text" id="name" class="form-control" placeholder="Nome" />
            </div>
            <div class="mt-2">
                <input type="email" id="email" class="form-control" placeholder="E-mail" />
            </div>
            <div class="mt-2">
                <input type="password" id="pass1" class="form-control" placeholder="Senha" />
            </div>
            <div class="mt-2">
                <input type="password" id="pass2" class="form-control" placeholder="Confirme Senha" />
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_fechar" onclick="reseta()">Fechar</button>
        <button type="button" class="btn btn-info" id="btn_salvar" onclick="save()">Salvar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetaEdit()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" style="display:none">Algo deu errado na Gravaçao</div>
        <div class="alert alert-success" style="display:none">Cadastrado com Sucesso</div>
        <form class="form form-vertical">
            <div>
                <input type="text" id="name_edit" class="form-control" placeholder="Nome" />
            </div>

            <div class="mt-2">
                <input type="email" id="email_edit" class="form-control" placeholder="E-mail" />
                <input type="hidden" id="email_old_edit" class="form-control" value="" />
            </div>
            <div class="mt-2">
                <input type="password" id="pass1_edit" class="form-control" placeholder="Senha" />
            </div>
            <div class="mt-2">
                <input type="password" id="pass2_edit" class="form-control" placeholder="Confirme Senha" />
                <input type="hidden" id="c_edit" value="" />
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_fechar" onclick="resetaEdit()">Fechar</button>
        <button type="button" class="btn btn-info" id="btn_salvar_edit" onclick="editExe()">Editar</button>
      </div>
    </div>
  </div>
</div>

  <input type="hidden" id="token">

@endsection

@section('scripts')
<script>
function conect(){
	var email = $("#email_login").val();
	var password = $("#password_login").val();
    $.ajax({
      url:"http://localhost:8000/api/auth/login",
      type:"POST",
      dataType:"json",
      data:{email:email, password:password},
      beforeSend:function(xhr){
        xhr.setRequestHeader('Accept', 'application/json');
      },
      success:function(data){
        $("#token").val(data.access_token);
        $("#login").hide();
        $("#loged").show();
        list();
      }
    });


  }


  var token = $("#token").val();


  function list(){
    var token = $("#token").val();
    $.ajax({
      url:"{{url()->current()}}/api/list",
      type:"GET",
      dataType:"json",
      beforeSend:function(xhr){
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Authorization', 'Bearer '+token);
      },
      success:function(data){
        console.log(data.users);
        var html = "";
        var qtd = data.users.length;
        for(i=0;i<qtd;i++){
          html += "<tr>";
          html += "<td>" + data.users[i].name + "</td>";
          html += "<td>" + data.users[i].email + "</td>";
          html += '<td style="width:20px"><a href="#" class="btn btn-sm btn-info text-white" onclick="callEdit('+data.users[i].user_id+')"  data-toggle="modal" data-target="#editModal">Editar</a></td>';
          html += '<td style="width:20px"><a href="#" class="btn btn-sm btn-info text-white" onclick="del('+data.users[i].user_id+')">Excluir</a></td>';
          html += "</tr>";
        }
        $("#body").html("");
        $("#body").append(html);

      }
    });
  }




    function reseta(){
        $("#name").val("");
        $("#email").val("");
         $("#pass1").val("");
        $("#pass2").val("");
        $(".alert").prop('display', 'none');
    }

    function resetaEdit(){
        $("#name_edit").val("");
        $("#email_edit").val("");
        $("#email_old_edit").val("");
        $("#pass1_edit").val("");
        $("#pass2_edit").val("");
        $(".alert").prop('display', 'none');
    }



    function save(){
          var token = $("#token").val();
          /*------------- AJAX PARA SALVAR ------------------*/

          var name  = $("#name").val();
          var email = $("#email").val();

          var pass  = $("#pass1").val();
          var pass2 = $("#pass2").val();

          if((pass == "" || pass2 == "") || (pass != pass2)){
              alert("Senhas no conferem. As senhas sao obrigatorias.");
              return false;
          }


          //alert("Nome:"+name+", E-mail:"+email+", Pass1:"+pass+", Pass2:"+pass2);


          if(name != "" && email != ""){

              $.ajax({
                  url:"{{url()->current()}}/api/adicionar",
                  type:"POST",
                  data:{name:name,email:email,password:pass,password_confirmation:pass2},
                  beforeSend:function(xhr){
                      xhr.setRequestHeader('Accept', 'application/json');
                      xhr.setRequestHeader('Authorization', 'Bearer '+token);
                  },
                  success:function(data){

                      //alert(data);

                      //document.location.reload(true);
                      //window.location.reload();
                      list();
                  },
                  error:function(xhr, err){
                      console.log("xhr:"+xhr+", erro:"+err);
                  }
              });
          }else{
              alert("Todos os campos são obrigatórios.");
              return false;
          }



    }

    function callEdit(hash)
    {
        var token = $("#token").val();
        $.ajax({
            url:"{{url()->current()}}/api/call_edit?hash="+hash,
            type:"GET",
            dataType:"json",
            beforeSend:function(xhr){
              xhr.setRequestHeader('Accept', 'application/json');
              xhr.setRequestHeader('Authorization', 'Bearer '+token);
            },
            success:function(data){

                // console.log(data.tels);

                $("#name_edit").val(data.user.name);
                $("#email_edit").val(data.user.email);
                $("#email_old_edit").val(data.user.email);
                $("#c_edit").val(hash);



            },
            error:function(xhr, err){
                alert("Ocorreu um erro inesperado");
            }
        });
    }


    function editExe(){
        var token = $("#token").val();
        var name      = $("#name_edit").val();
        var email     = $("#email_edit").val();
        var email_old = $("#email_old_edit").val();
        var c_edit    = $("#c_edit").val();


        //console.log(telefones);

        var pass  = $("#pass1_edit").val();
        var pass2 = $("#pass2_edit").val();

        if((pass != "" || pass2 != "") && (pass != pass2)){
            alert("Senhas no conferem.");
            return false;
        }

        if(name != "" && email != ""){

            $.ajax({
                url:"{{url()->current()}}/api/edit_exe",
                type:"PUT",
                dataType:"json",
                data:{c_edit:c_edit,name:name,email:email,email_old:email_old,password:pass,password_confirmation:pass2},
                beforeSend:function(xhr){
                    xhr.setRequestHeader('Accept', 'application/json');
                    xhr.setRequestHeader('Authorization', 'Bearer '+token);
                    $("#btn_salvar_edit").prop('disabled', 'disabled');
                },
                success:function(data){
                    alert(data.resp);
                    $("#btn_salvar_edit").prop('disabled', false);
                    //document.location.reload(true);
                    list();
                },
                error:function(xhr, err){
                    console.log("xhr:"+xhr+", erro:"+err);
                }
            });
        }else{
            alert("Todos os campos são obrigatórios.");
            return false;
        }
    }

    var field = "name";
    var order = "asc";


    function getSearchPaginate(order="asc", field="name"){
        var token = $("#token").val();
        //var page = $(".pagination a").attr('href').split('page=')[1];
        var search = $("#txt-search").val();

        $.ajax({
            url:"{{url()->current()}}/api/users_ajax_search/search?search="+search+"&order="+order+"&field="+field,
            type:"GET",
            beforeSend:function(xhr){
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', 'Bearer '+token);
            },
            success:function(data){

              var html = "";
              var qtd = data.resultSet.length;
              for(i=0;i<qtd;i++){
                html += "<tr>";
                html += "<td>" + data.resultSet[i].name + "</td>";
                html += "<td>" + data.resultSet[i].email + "</td>";
                html += '<td style="width:20px"><a href="#" class="btn btn-sm btn-info text-white" onclick="callEdit('+data.resultSet[i].user_id+')"  data-toggle="modal" data-target="#editModal">Editar</a></td>';
                html += '<td style="width:20px"><a href="#" onclick="del('+data.resultSet.user_id+')" class="btn btn-sm btn-info text-white">Excluir</a></td>';
                html += "</tr>";
              }
              $("#body").html("");
              $("#body").append(html);
            }
        });

    }


    function getUsers(order="asc", field="name"){
        var token = $("#token").val();

          //alert("Ordem:"+order+", Campo:"+field);


         $.ajax({
            url:"{{url()->current()}}/api/users_ajax/fetch_data?order="+order+"&field="+field,
            type:"GET",
            beforeSend:function(xhr){
              xhr.setRequestHeader('Accept', 'application/json');
              xhr.setRequestHeader('Authorization', 'Bearer '+token);
            },
            success:function(data){

              var html = "";
              var qtd = data.resultSet.length;
              for(i=0;i<qtd;i++){
                html += "<tr>";
                html += "<td>" + data.resultSet[i].name + "</td>";
                html += "<td>" + data.resultSet[i].email + "</td>";
                html += '<td style="width:20px"><a href="#" class="btn btn-sm btn-info text-white" onclick="callEdit('+data.resultSet[i].user_id+')"  data-toggle="modal" data-target="#editModal">Editar</a></td>';
                html += '<td style="width:20px"><a href="#" onclick="del('+data.resultSet.user_id+')" class="btn btn-sm btn-info text-white">Excluir</a></td>';
                html += "</tr>";
              }
              $("#body").html("");
              $("#body").append(html);
            }
        });
    }



    var clicou = false;
    function ordem(campo){
        var search = $("#txt-search").val();
        field = campo;
        var pp = $("#porpagina").val();
        if(!clicou){
            order = 'asc';
            clicou = true;
            if(search != ""){
                getSearchPaginate('asc', campo);
            }else{
                getUsers('asc', campo);
            }
        }else{
            order = 'desc';
            clicou = false;
            if(search != ""){
                getSearchPaginate('desc', campo);
            }else{
                getUsers('desc', campo);
            }
        }
    }

    function del(code){
      var token = $("#token").val();
      var res = confirm('Confirma deletar este registro?');
      if(res){
        $.ajax({
           url:"{{url()->current()}}/api/users_delete/del?"+$.param({'code':code}),
           type:"DELETE",
           dataType:"json",
           beforeSend:function(xhr){
             xhr.setRequestHeader('Accept', 'application/json');
             xhr.setRequestHeader('Authorization', 'Bearer '+token);
           },
           success:function(data){
             alert(data.status);
             list();
           }
        });
      }
    }
</script>
@endsection
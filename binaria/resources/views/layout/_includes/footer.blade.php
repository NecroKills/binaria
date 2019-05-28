
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(document).ready(function (){

     // botão voltar da pagina de cadastro
    $("#voltar").on("click", function(){
        window.location.replace("/");
    });

    // botão adicionar da pagina inicial
    $("#adicionar").on("click", function(){
        window.location.replace("http://127.0.0.1:8000/vendedor/adicionar");
    });

    // botão adicionar da pagina inicial
    $("#relatorio").on("click", function(){
        window.location.replace("http://127.0.0.1:8000/rede/buscarRelatorio");
    });

  });
</script>

</body>
</html>

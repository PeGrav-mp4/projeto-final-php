<?php
// =============================================
// Arquivo: registrar.php
// Função: Salvar no banco cada mudança feita em uma tarefa
// Chamado pelo atualizar.php antes de aplicar a edição
// =============================================

// Recebe os dados da alteração e insere na tabela 'historico'
function registrarHistorico($conexao, $tarefa_id, $usuario_id, $campo, $valor_antigo, $valor_novo) {
    // Se o valor não mudou, não registra nada (evita lixo no histórico)
    if ($valor_antigo == $valor_novo) return;

    // intval() garante que o valor é um número inteiro (segurança)
    $tarefa_id = intval($tarefa_id);
    $usuario_id = intval($usuario_id);

    // mysqli_real_escape_string() protege contra injeção de SQL nos textos
    $campo = mysqli_real_escape_string($conexao, $campo);
    $valor_antigo = mysqli_real_escape_string($conexao, $valor_antigo);
    $valor_novo = mysqli_real_escape_string($conexao, $valor_novo);

    // Monta e executa o INSERT na tabela historico
    $sql = "INSERT INTO historico (tarefa_id, usuario_id, campo_alterado, valor_antigo, valor_novo) 
            VALUES ($tarefa_id, $usuario_id, '$campo', '$valor_antigo', '$valor_novo')";

    return mysqli_query($conexao, $sql);
}
?>

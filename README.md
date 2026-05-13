# 📝 Gerenciador de Tarefas Colaborativo

Projeto de conclusão desenvolvido para a disciplina de Programação Orientada a Objetos / PHP. Trata-se de um sistema web nativo para controle de atividades em equipe, desenvolvido puramente com **PHP, HTML5, CSS3 e MySQL**, sem a utilização de frameworks ou bibliotecas externas.

## 🚀 Tecnologias Utilizadas
- **PHP 8.x (Nativo)**
- **MySQL / MariaDB**
- **HTML5 (Semântico)**
- **CSS3 (Vanilla)**

## 👥 Equipe e Divisão do Trabalho

Para facilitar a defesa do código, as responsabilidades foram divididas estrategicamente entre os integrantes do grupo:

### 1. Gustavo Henrique Garcia Cavalli (RGM: 43635563)
**Foco:** Front-end, UX/UI e Interface (*Desenvolvimento visual e estrutural*)
- Criação e manutenção do arquivo `style.css`.
- Implementação de layouts responsivos utilizando `Flexbox` e media queries (`@media max-width`).
- Desenvolvimento visual das telas de Login, Cadastro e Dashboard.
- Definição do *Design System* padrão do projeto (cores, fontes, botões, states de hover e reset CSS).

### 2. Luana Brotto de Jesus (RGM: 41940270)
**Foco:** Banco de Dados e CRUD Principal (*Núcleo do sistema*)
- Modelagem do Banco de Dados Relacional (`banco.sql`).
- Implementação da lógica de conexão ao banco de dados (`conexao.php`).
- Construção do CRUD de Tarefas (arquivos `adicionar.php`, `listar.php`, `salvar_tarefa.php`, `excluir.php`).
- Desenvolvimento do sistema de **Filtros Dinâmicos** via método HTTP `GET`.

### 3. Pedro Henrique Policeno (RGM: 41829964)
**Foco:** Segurança, Sessões e Features Colaborativas (*Lógica avançada*)
- Implementação de Segurança com `password_hash()` e `password_verify()`.
- Criação do Sistema de Autenticação e proteção de rotas via `$_SESSION`.
- Desenvolvimento da lógica de permissões: validação de criador/responsável em `atualizar.php`.
- Construção do **Histórico de Alterações Global** e do módulo de **Comentários**.

---

## 🛠️ Como Executar o Projeto Localmente

1. Certifique-se de ter o **XAMPP/WAMP** instalado.
2. Inicie o serviço do **MySQL**.
3. Importe o arquivo `database/banco.sql` no seu *phpMyAdmin* para gerar o banco `gerenciador_tarefas` e suas tabelas.
   - *Alternativa:* Se preferir, basta rodar o arquivo `setup_db.php` na raiz do projeto (via terminal ou abrindo no navegador) que ele fará a importação do banco automaticamente.
4. Caso a sua porta MySQL ou usuário seja diferente do padrão XAMPP (`root`, sem senha, porta 3306), ajuste o arquivo `config/conexao.php`.
5. Hospede a pasta do projeto no `htdocs` ou inicie o servidor embutido do PHP na raiz do projeto:
   ```bash
   php -S localhost:8000
   ```
6. Acesse no navegador: `http://localhost:8000/projeto/index.php`

## 📖 Funcionalidades Implementadas
- [x] Cadastro de Usuários com senha criptografada.
- [x] Login e Logout gerenciados via *Sessão (Cookies)*.
- [x] Criação de tarefas e delegação para membros específicos.
- [x] Listagem de todas as tarefas com filtros por status, responsável e data limite.
- [x] Permissão estrita: apenas o criador ou o responsável da tarefa pode atualizar seu status ou excluí-la.
- [x] Sistema de Comentários interativos em cada tarefa.
- [x] Histórico/Log global auditável que registra: quem alterou, o que alterou, valor antigo e valor novo, com data e hora.

## 🎓 Requisitos Acadêmicos Cumpridos
- Estrutura completa utilizando HTML Semântico (`<header>`, `<main>`, `<footer>`, `<section>`).
- Uso de CSS puramente manual.
- Interação completa com banco de dados usando biblioteca `mysqli`.
- Estruturas de laço (`while`) e controle de fluxo (`if/else/switch`).
- Uso correto das globais `$_GET` e `$_POST`.

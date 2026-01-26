# Vegas Digital Menu - Sistema de Cardápio Digital

Sistema completo de cardápio digital para o Vegas Motel, desenvolvido em PHP puro e MySQL, otimizado para hospedagem compartilhada na Hostinger.

## 📋 Características

- ✅ Frontend público responsivo com tema Vegas (preto, vinho, roxo, neon)
- ✅ Painel administrativo completo (CRUD de produtos)
- ✅ Autenticação de administrador
- ✅ Proteção contra SQL Injection (prepared statements)
- ✅ URLs amigáveis (.htaccess)
- ✅ Design responsivo para todos os dispositivos
- ✅ 100+ produtos pré-cadastrados em 10 categorias

## 🚀 Instalação na Hostinger

### Passo 1: Upload dos Arquivos

1. Acesse o painel da Hostinger
2. Vá em **Arquivos** → **Gerenciador de Arquivos**
3. Navegue até o diretório `public_html`
4. Faça upload de todos os arquivos do projeto mantendo a estrutura de pastas

### Passo 2: Configurar o Banco de Dados

1. No painel da Hostinger, vá em **Bancos de Dados** → **Gerenciar**
2. Crie um novo banco de dados MySQL:
   - Nome: `vegas_menu` (ou outro nome de sua preferência)
   - Anote o usuário e senha do banco
3. Acesse o **phpMyAdmin**
4. Selecione o banco de dados criado
5. Clique em **Importar**
6. Selecione o arquivo `database.sql`
7. Clique em **Executar**

### Passo 3: Configurar a Conexão

1. Abra o arquivo `config/database.php`
2. Edite as configurações com os dados do seu banco:

```php
define('DB_HOST', 'localhost');  // Geralmente localhost na Hostinger
define('DB_USER', 'seu_usuario');  // Usuário do banco de dados
define('DB_PASS', 'sua_senha');    // Senha do banco de dados
define('DB_NAME', 'vegas_menu');   // Nome do banco de dados
```

3. Salve o arquivo

### Passo 4: Ajustar Permissões (se necessário)

Se encontrar erros de permissão, ajuste as permissões:
- Pastas: `755`
- Arquivos PHP: `644`

## 🌐 URLs de Acesso

Após a instalação, você pode acessar:

- **Cardápio Público:** `https://seudominio.com/` ou `https://seudominio.com/cardapio`
- **Painel Admin:** `https://seudominio.com/painel/login.php`

## 🔐 Credenciais de Administrador

**Usuário:** `admin`  
**Senha:** `admin`

⚠️ **IMPORTANTE:** Após o primeiro acesso, altere a senha padrão por segurança!

Para alterar a senha do administrador:

1. Acesse o phpMyAdmin
2. Selecione o banco de dados `vegas_menu`
3. Abra a tabela `admin_users`
4. Execute o seguinte SQL substituindo `nova_senha`:

```sql
UPDATE admin_users 
SET password = '$2y$10$YourHashedPasswordHere' 
WHERE username = 'admin';
```

Para gerar o hash da senha, você pode usar:

```php
<?php
echo password_hash('sua_nova_senha', PASSWORD_DEFAULT);
?>
```

## 📁 Estrutura do Projeto

```
vegas-digital-menu/
├── .htaccess                 # Configurações Apache (URLs amigáveis)
├── database.sql              # Script SQL de instalação
├── README.md                 # Este arquivo
├── INSTALL.md               # Documentação de instalação
├── assets/                   # Recursos estáticos
│   ├── css/
│   │   └── style.css        # Estilos do tema Vegas
│   ├── js/                  # JavaScript (futuro)
│   └── images/              # Imagens (futuro)
├── config/
│   └── database.php         # Configuração do banco de dados
├── public/
│   └── index.php            # Página pública do cardápio
└── painel/                   # Painel administrativo
    ├── index.php            # Dashboard admin
    ├── login.php            # Login do admin
    ├── logout.php           # Logout
    ├── produto_add.php      # Adicionar produto
    ├── produto_edit.php     # Editar produto
    └── produto_delete.php   # Excluir produto
```

## 🗄️ Estrutura do Banco de Dados

### Tabela: produtos

| Campo       | Tipo          | Descrição                      |
|-------------|---------------|--------------------------------|
| id          | INT (PK)      | ID único do produto            |
| nome        | VARCHAR(255)  | Nome do produto                |
| descricao   | TEXT          | Descrição detalhada            |
| preco       | DECIMAL(10,2) | Preço em reais                 |
| categoria   | VARCHAR(100)  | Categoria do produto           |
| disponivel  | BOOLEAN       | Disponibilidade (Sim/Não)      |
| created_at  | TIMESTAMP     | Data de criação                |
| updated_at  | TIMESTAMP     | Data da última atualização     |

### Tabela: admin_users

| Campo      | Tipo         | Descrição                |
|------------|--------------|--------------------------|
| id         | INT (PK)     | ID único do usuário      |
| username   | VARCHAR(50)  | Nome de usuário          |
| password   | VARCHAR(255) | Senha (hash bcrypt)      |
| created_at | TIMESTAMP    | Data de criação          |

## 📦 Categorias de Produtos

O sistema vem com produtos pré-cadastrados nas seguintes categorias:

1. **Porções Extras** - Acompanhamentos e petiscos rápidos
2. **Bebidas** - Refrigerantes, águas e sucos
3. **Cervejas** - Variedade de cervejas nacionais e importadas
4. **Lanches** - Hambúrgueres e sanduíches
5. **Pizzas** - Pizzas diversas
6. **Sobremesas** - Doces e sobremesas
7. **Pratos Executivos** - Refeições completas
8. **Drinks e Coquetéis** - Bebidas alcoólicas preparadas
9. **Cafés e Chás** - Bebidas quentes
10. **Petiscos** - Aperitivos variados

## 🎨 Personalização

### Cores do Tema

O tema pode ser personalizado editando o arquivo `assets/css/style.css`:

```css
:root {
    --color-black: #0a0a0a;
    --color-wine: #8b1538;
    --color-purple: #6b2d5c;
    --color-neon-pink: #ff006e;
    --color-neon-purple: #b565d8;
    --color-gold: #ffd700;
    --color-white: #ffffff;
    --color-gray: #cccccc;
}
```

## 🔒 Segurança

O sistema implementa as seguintes medidas de segurança:

- ✅ Prepared Statements (proteção contra SQL Injection)
- ✅ Validação e sanitização de entrada de dados
- ✅ Senhas criptografadas com bcrypt
- ✅ Sessões seguras para autenticação
- ✅ Proteção de arquivos sensíveis via .htaccess

## 🛠️ Funcionalidades do Painel Admin

### Listar Produtos
- Visualize todos os produtos cadastrados
- Informações: ID, Nome, Categoria, Preço, Disponibilidade
- Ordenação por categoria e nome

### Adicionar Produto
- Formulário completo de cadastro
- Campos: Nome, Descrição, Preço, Categoria, Disponibilidade
- Validação de dados obrigatórios
- Sugestão de categorias existentes

### Editar Produto
- Edite todos os campos de um produto existente
- Mesmas validações do cadastro
- Preserva dados não modificados

### Excluir Produto
- Exclusão com confirmação JavaScript
- Mensagem de sucesso/erro
- Não permite recuperação (exclusão permanente)

## 📱 Responsividade

O sistema é totalmente responsivo e se adapta a:
- 📱 Smartphones (320px+)
- 📱 Tablets (768px+)
- 💻 Desktops (1024px+)
- 🖥️ Telas grandes (1920px+)

## 🐛 Resolução de Problemas

### Erro de conexão com banco de dados
- Verifique as credenciais em `config/database.php`
- Confirme que o banco de dados foi criado
- Verifique se o script SQL foi executado

### Página em branco
- Ative a exibição de erros PHP temporariamente
- Verifique permissões dos arquivos
- Consulte os logs de erro do servidor

### Produtos não aparecem
- Confirme que o script SQL foi executado completamente
- Verifique a tabela `produtos` no phpMyAdmin
- Confirme que há produtos com `disponivel = 1`

### CSS não carrega
- Verifique se o arquivo `assets/css/style.css` existe
- Confirme as permissões do arquivo
- Limpe o cache do navegador

## 📞 Suporte

Para questões técnicas ou problemas:
1. Verifique a seção de resolução de problemas
2. Consulte os logs de erro do PHP
3. Verifique as configurações do servidor

## 📝 Licença

Este projeto foi desenvolvido especificamente para o Vegas Motel.

## 🎉 Recursos Futuros (Opcional)

- [ ] Upload de imagens de produtos
- [ ] Sistema de pedidos online
- [ ] Integração com WhatsApp
- [ ] Impressão de cardápio em PDF
- [ ] Multi-idiomas
- [ ] Sistema de promoções

---

**Desenvolvido com ❤️ para o Vegas Motel**

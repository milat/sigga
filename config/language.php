<?php

return [

    'default' => 'pt-br',

    'pt-br' => [
        'home' => 'Home',
        'login' => 'Login',
        'logout' => 'Sair',
        'create' => 'Cadastrar',
        'insert' => 'Cadastrar',
        'edit' => 'Editar',
        'view' => 'Visualizar',
        'update' => 'Atualizar',
        'search' => 'Buscar',
        'return' => 'Voltar',
        'link' => 'Vincular',
        'link_existing_document' => 'Vincular documento existente',
        'update_status_after_link' => 'Atualizar status para "Enviado em processo"',
        'replacing_request_document' => 'Obs: Essa ação irá substituir o documento atual',
        'request_no_document_linked' => 'Nenhum documento vinculado à solicitação.',
        'requests_waiting_feedback' => ' solicitações ainda aguardam retorno:',
        'new' => 'Novo',
        'close' => 'Fechar',
        'download' => 'Download',
        'active' => 'Ativo',
        'inactive' => 'Inativo',
        'combo' => 'combo',
        'warn' => 'Aviso',

        'permission' => 'Permissão',
        'permissions' => 'Permissões',
        'permission_access' => 'Acesso',
        'permission_access_is_alowed' => 'Permitido',
        'permission_access_not_allowed' => 'Negado',

        'request' => 'Solicitação',
        'requests' => 'Solicitações',
        'request_requester' => 'Solicitante',
        'request_requester_type' => 'Tipo solicitante',
        'request_responsible' => 'Usuário responsável',
        'request_owner_id' => 'Solicitante',
        'request_category_id' => 'Tipo',
        'request_document_id' => 'Documento',
        'request_status_id' => 'Status',
        'request_title' => 'Título',
        'request_description' => 'Descrição',
        'request_place' => 'Localização',
        'request_place_placeholder' => 'Local referente à solicitação (se houver)',
        'request_reminder' => 'Lembrete',
        'request_created_at' => 'Data cadastro',

        'progress' => 'Andamento',
        'progresses' => 'Andamentos',
        'progress_description' => 'Descrição',
        'progress_description_placeholder' => 'Novo andamento',
        'progress_created_by_user_id' => 'Usuário',
        'progress_created_at' => 'Data',

        'attachment' => 'Anexo',
        'attachments' => 'Anexos',
        'attachment_title' => 'Título',
        'attachment_title_placeholder' => 'Título do novo anexo',
        'attachment_date' => 'Data',
        'attachment_note' => 'Observação',
        'attachment_file' => 'Arquivo',
        'attachment_user_id' => 'Usuário',
        'attachment_created_at' => 'Data',

        'citizen' => 'Cidadão',
        'citizens' => 'Cidadãos',
        'citizen_name' => 'Nome',
        'citizen_identity_document' => 'CPF',
        'citizen_identity_document_placeholder' => 'xxx.xxx.xxx-xx',
        'citizen_email' => 'E-mail',
        'citizen_birth' => 'Nascimento',
        'citizen_note' => 'Observação',
        'citizen_is_active' => 'Status',
        'citizen_dependents' => 'Dependentes',

        'dependent' => 'Dependente',
        'dependents' => 'Dependentes',
        'dependent_name' => 'Nome',
        'dependent_identity_document' => 'RG',
        'dependent_birth' => 'Nascimento',
        'dependent_note' => 'Observação',
        'dependent_is_active' => 'Status',
        'dependent_citizen_id' => 'Responsável',

        'config' => 'Configuração',
        'configs' => 'Configurações',

        'phone' => 'Telefone',
        'phones' => 'Telefones',
        'phone_type_id' => 'Tipo telefone',
        'phone_number' => 'Número telefone',
        'phone_number_placeholder' => '(xx) xxxx?-xxxx',
        'phone_note' => 'Observação telefone',
        'phone_main' => 'Principal',
        'phone_secondary' => 'Secundário',

        'address' => 'Endereço',
        'address_type_id' => 'Tipo',
        'address_code' => 'CEP',
        'address_code_placeholder' => 'xxxxx-xxx',
        'address_name' => 'Logradouro',
        'address_name_placeholder' => 'Nome da rua ou avenida',
        'address_number' => 'Nº',
        'address_extra' => 'Complemento',
        'address_neighborhood' => 'Bairro',
        'address_city' => 'Cidade',
        'address_state' => 'Estado',
        'address_note' => 'Observação',

        'user' => 'Usuário',
        'users' => 'Usuários',
        'user_name' => 'Nome',
        'user_email' => 'E-mail',
        'user_identity_document' => 'CPF',
        'user_identity_document_placeholder' => 'xxx.xxx.xxx-xx',
        'user_role_id' => 'Perfil',
        'user_is_active' => 'Status',

        'password' => 'Senha',
        'password_update' => 'Alterar minha senha',
        'password_current' => 'Senha atual',
        'password_new' => 'Nova senha',
        'password_confirm' => 'Confirmar nova senha',
        'password_invalid' => 'Senha atual inválida',

        'login_remember_me' => 'Manter logado',
        'login_enter' => 'Entrar',

        'dashboard' => 'Dashboard',
        'dashboard_info_label' => 'total de solicitações',
        'dashboard_request_category_month' => 'Solicitações por Categoria / Último mês',
        'dashboard_request_category_year' => 'Solicitações por Categoria / Último ano',
        'dashboard_request_status_month' => 'Solicitações por Status / Último mês',
        'dashboard_request_status_year' => 'Solicitações por Status / Último ano',

        'category' => 'Tipo de Solicitação',
        'categories' => 'Tipos de Solicitação',
        'category_name' => 'Descrição',
        'category_colour' => 'Cor',
        'category_is_active' => 'Status',

        'role' => 'Perfil',
        'roles' => 'Perfis',
        'role_name' => 'Descrição',
        'role_is_active' => 'Status',

        'document' => 'Documento',
        'documents' => 'Documentos',
        'document_type_id' => 'Tipo',
        'document_date' => 'Data envio',
        'document_code' => 'Número',
        'document_code_placeholder' => 'xxxx/xxxx',
        'document_title' => 'Título',
        'document_note' => 'Observação',

        'file' => 'Arquivo',
        'file_name' => 'Arquivo',
        'file_extension' => 'Extensão',
        'file_path' => 'Caminho',

        'application' => 'Requerimento',
        'recommendation' => 'Indicação',
        'motion' => 'Moção',
        'letter' => 'Ofício',
        'memo' => 'Memorando',

        'organization' => 'Entidade',
        'organizations' => 'Entidades',
        'organization_name' => 'Nome',
        'organization_branch' => 'Ramo',
        'organization_branch_placeholder' => 'Ramo de atividade',
        'organization_identity_document' => 'CNPJ',
        'organization_identity_document_placeholder' => '',
        'organization_email' => 'E-mail',
        'organization_email_placeholder' => '',
        'organization_contact' => 'Responsável',
        'organization_contact_placeholder' => 'Pessoa responsável ou contato na entidade',
        'organization_note' => 'Observação',
        'organization_is_active' => 'Status',

        'activities' => 'Atividades',
        'activity' => 'Atividade',
        'activity_name' => 'Nome',
        'activity_description' => 'Descrição',
        'activity_note' => 'Observação',
        'activity_is_active' => 'Status',

        'activity_class' => 'Turma',
        'activity_classes' => 'Turmas',
        'activity_class_responsible_user_id' => 'Responsável',
        'activity_class_place' => 'Local',
        'activity_class_schedule' => 'Dias e Horários',
        'activity_class_max_subscribers' => 'Quantidade de vagas',
        'activity_class_note' => 'Observação',
        'activity_class_is_active' => 'Status',

        'activity_attend' => 'Presença',
        'activity_class' => 'Turma',
        'activity_lesson' => 'Aula',
        'activity_schedule' => 'Agenda',

        'activity_subscribers' => 'Matrículas',
        'activity_subscriber' => 'Matrícula',
        'activity_subscriber_name' => 'Nome',
        'activity_subscriber_is_active' => 'Status',

        'superuser' => 'Admin',

        'all' => 'Todos',
        'opened' => 'Aberta',
        'sent' => 'Enviada em processo',
        'received' => 'Recebida',
        'canceled' => 'Cancelada',
        'completed' => 'Concluída',
        'failed' => 'Não atendida',

        'records_found' => 'registros encontrados',
        'no_records_found' => 'Nenhum registro encontrado',
        'not_found' => 'Registro não localizado',
        'insert_success' => 'Cadastro realizado com sucesso',
        'insert_error' => 'Erro ao cadastrar',
        'update_success' => 'Cadastro atualizado com sucesso',
        'update_error' => 'Erro ao atualizar',
        'login_error' => 'Usuário e/ou senha inválidos',
        'logout_error' => 'Erro ao deslogar usuário',
        'download_error' => 'Erro ao baixar arquivo',
        'login_error' => 'Usuário e/ou senha inválidos',
        'role_permission_label' => 'Ao alterar as permissões o acesso é atualizado automaticamente',
        'role_permission_update_error' => 'Erro ao atualizar permissão',

        'copy_me' => 'copiar para área de transferência',
        'view_me' => 'Visualizar cadastro',

        'about_system' => 'Sigga é um sistema para gestão de gabinete. Seu propósito é gerenciar os cadastros, demandas e documentação para que o agente político e seus assessores tenham total controle e visão das atividadaes em andamento e as já concluídas, mantendo o histórico e dados para análise.',

        'feedback_sent' => '<capslock_office_name> ESTÁ COM VOCÊ!<break><break>Informamos que seu pedido referente à <request_title> está em processo! <office_name> protocolou no dia <document_date>: <document_type_name> nº <document_code>. Aguarde que em breve lhe informaremos mais sobre o pedido.<break><break><office_name>.',

        'feedback_done' => '',

        'footer' => 'developed by milat.dev - '.date('Y'),

    ]
];

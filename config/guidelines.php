
<?php 

return array(
	'demo_mode_dialog' =>array(
		                  "admin.dashboard" => "<h3> Painel </h3>
							<li> Exibir o resumo de todo o sistema, como número de passeios, motoristas registrados, total de ganhos, total de viagens realizadas, viagens em andamento e últimas viagens </li>
							<li> No Painel, podemos visualizar todos os dados do resumo da carteira e dos passeios recentes. </li>
							<li> O Superadministrador pode visualizar os dados completos das informações do usuário e do provedor. </li>
							",

							"admin.dispatcher.index" => "<h3> Despachante </h3>
							<li> Usando o painel do despachante, os passeios podem ser atribuídos manualmente aos motoristas. </li> <li> Possui a opção subcampos de pesquisa, passeios atribuídos e cancelados. </li> <li>
							Ele mostrará os detalhes dos motoristas e a localização do mapa do ponto inicial ao final. </li> ",

							"admin.dispute.index" => "<h3> Disputa </h3>
							<li> No painel de disputas, podemos criar as disputas manualmente
							A disputa que foi adicionada no administrador refletirá no front end
							Neste painel, podemos criar, editar, excluir e pesquisar as disputas. </li> <li>
							Podemos exportar as disputas via CSV, PDF e planilha do Excel.
							Além disso, podemos monitorar quais das disputas estão ativas e inativas. </li> <li>
							Este painel não estará visível no modo de demonstração. </li> ",

							"admin.heatmap" => "<h3> Mapa de Calor </h3> <li> Nos Mapas de Calor, o administrador pode exibir todos os locais dos Usuários e Drivers. </li>
							<li> Podemos visualizar os mapas completos, que permitem aumentar e diminuir o zoom. </li>
							<li> Nos mapas de calor, o administrador pode visualizar todas as classificações dos drivers na página completa. </li> ",

							"admin.godseye" => "<h3> Godseye </h3> <li> O superadministrador pode visualizar todos os mapas do usuário, Provedor, Usuário disponível e Provedor disponível na visualização do mapa. </li>
							<li> O Superadministrador pode clicar e visualizar o usuário e o provedor no aplicativo. </li>
							<li> Na visualização do mapa, podemos visualizar o usuário e o provedor na visualização de satélite. Também podemos diminuir o zoom. </li>
							",

							"admin.user.index" => "<h3> Usuários </h3> <li> O Superadministrador pode fazer o gerenciamento de usuários
							O administrador pode adicionar, editar, excluir o usuário e seus direitos.
							O administrador pode visualizar o histórico completo do usuário. </li>
							<li> O Superadministrador tem o direito de excluir o usuário neste módulo. Os campos completos do usuário podem ser acessados ​​pelo administrador. </li> <li>
							O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> Na lista de usuários, o superadministrador pode exibir o ID, nome e sobrenome, email, celular, classificação, valor da carteira e ação. </li>
							<li> O superadministrador pode procurar um usuário específico nos campos de pesquisa. </li> <li>
							O administrador tem o direito de editar e excluir um usuário no aplicativo Web. </li> <li>
							O registro de novos usuários que ingressaram no aplicativo será armazenado aqui. </li>
							
							<b> No modo Demo, você não pode adicionar, editar e excluir nenhum usuário </b>
							",

							"admin.provider.index" => "<h3> Provedores </h3> <li> O administrador pode gerenciar os drivers registrados no sistema. </li> <li> 
							O administrador pode revisar os documentos e veículos adicionados por eles. </li> <li> 
							O administrador pode aprovar / rejeitar qualquer conta de motorista. </li> <li>
							O motorista poderá ficar online apenas se a conta tiver sido aprovada pelo administrador. </li> <li> 
							O administrador pode adicionar / modificar / excluir qualquer driver. </li> <li>
						   O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li> <li>
						   O registro de novos fornecedores que ingressaram no registro do aplicativo será armazenado aqui. </li> <li>
						   O Superadministrador tem o direito de tornar um driver online ou offline. </li> <li>
						   O Superadministrador tem o direito de tornar um driver ativo e inativo
						   O administrador tem permissão para adicionar, editar e excluir o provedor. </li> <li>
						   O administrador tem o direito de atribuir o tipo de serviço com base no aplicativo do veículo Driver. </li> <li>
						   O administrador pode aprovar a documentação do motorista e ele pode visualizar a declaração completa. </li>
						   
						   <b> No modo Demo, você não pode adicionar, editar e excluir nenhum usuário. </b> 
						   ",

							"admin.dispatch-manager.index" => "<h3> Painel de expedidor </h3> <li> O administrador pode gerenciar os detalhes do expedidor que foram designados para despachar o táxi manualmente </li> <li>
							Os detalhes do expedidor, como nome, email e número de celular, serão armazenados </li> <li>
							O superadministrador pode adicionar, editar e excluir os arquivos. </li> <li>
							O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<b> No modo Demo, você não pode adicionar, editar e excluir o usuário do expedidor </b>
							",

							"admin.fleet.index" => "<h3> Painel da frota </h3> <li> O administrador gerencia os usuários da frota. </li> <li>
							O proprietário da frota gerencia os detalhes do proprietário da frota, como nome, email, imagem e nome da empresa </li> <li>
							A lista de fornecedores em cada frota pode ser visualizada com base em cada empresa </li> <li>
							O administrador pode adicionar proprietários de frotas manualmente no painel do administrador </li> <li>
							Esse processo ocorre quando um usuário deseja emprestar seu carro a terceiros e se aproxima da empresa e fornece os detalhes </li> <li>
							O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li> <li>
							Os detalhes incluem nome, email, número de telefone, senha e logotipo da empresa </li>
							<b> No modo de demonstração, você não pode adicionar, editar, excluir o usuário da frota </b>
							",

							"admin.account-manager.index" => "<h3> Gerente de contas </h3> <li> O administrador pode gerenciar os detalhes do gerente de contas no painel de administração </li> <li>
							O gerente de contas é quem gerencia o rastreamento completo dos provedores que ganham </li> <li>
							O administrador armazena detalhes como nome, celular e correio do gerente da conta </li> <li>
							O administrador pode adicionar manualmente o gerente de contas no painel </li> <li>
							O administrador adiciona detalhes como nome, email, senha e número de celular </li> <li>
							Depois de adicionado, o gerente da conta pode fazer login com as credenciais fornecidas e gerenciar o extrato de pagamento do provedor </li> <li>
							O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li> <li>
							Nesta lista de contas, o gerente de contas, a lista da conta que será exibida </li>
							<b> No modo Demo, você não pode adicionar, editar, excluir o gerente de contas </b>
							",

							"admin.ride.statement" => "<h3> Declarações gerais </h3> <li> Na declaração geral, o superadministrador pode ver toda a declaração de viagem. </li> <li>
							Na declaração geral, podemos filtrar o percurso com as datas De e Até. </li> <li>
							Nesta página, podemos ver todos os passeios totais, viagens canceladas e receita do usuário </li> <li>
							O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li> <li>
							O administrador tem acesso para visualizar todos os registros e pesquisar os registros. </li> <li>
							No extrato geral, ele possui o ID da reserva, Picked UP, Dropped, Detalhes da solicitação, comissões, Data datada, Status e Ganhos. </li>
							",

							"admin.ride.statement.provider" => "<h3> Instruções do provedor </h3> <li> Na declaração do provedor, o superadministrador pode ver toda a declaração do provedor. </li> <li>
							O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li> <li>
							Na declaração do provedor, ele possui o nome, o celular, o status, o total de passeios, o total de ganhos, as comissões, o ingresso em e os detalhes. </li> <li>
							O administrador tem acesso para visualizar os detalhes da viagem na declaração do provedor. </li>
							",

							"admin.ride.statement.today" => "<h3> Declarações diárias </h3> <li> Na declaração geral, o superadministrador pode ver toda a declaração de viagem. </li> <li>
							Na declaração geral, podemos filtrar o percurso com as datas De e Até. </li> <li>
							Nesta página, podemos ver todos os passeios totais, viagens canceladas e receita do usuário </li> <li>
							O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li> <li>
							O administrador tem acesso para visualizar todos os registros e pesquisar os registros. </li> <li>
							No extrato geral, ele possui o ID da reserva, Picked UP, Dropped, Detalhes da solicitação, Comissões, Data datada, Status e Ganhos. </li> <li>
							Nisto, podemos obter a declaração diária dos detalhes da viagem. </li>
							",

							"admin.ride.statement.monthly" => "<h3> Declarações mensais </h3> <li> Na declaração geral, o superadministrador pode ver toda a declaração de viagem. </li> <li>
							Na declaração geral, podemos filtrar o percurso com as datas De e Até. </li> <li>
							Nesta página, podemos ver todos os passeios totais, viagens canceladas e receita do usuário </li> <li>
							O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li> <li>
							O administrador tem acesso para visualizar todos os registros e pesquisar os registros. </li> <li>
							No extrato geral, ele possui o ID da reserva, Picked UP, Dropped, Detalhes da solicitação, Comissões, Data datada, Status e Ganhos. </li> <li>
							Nisto, podemos obter a declaração mensal dos detalhes da viagem. </li>
							",

							"admin.ride.statement.yearly" => "<h3> Declarações anuais </h3> <li> Na declaração geral, o superadministrador pode ver toda a declaração de viagem. </li> <li>
							Na declaração geral, podemos filtrar o percurso com as datas De e Até. </li> <li>
							Nesta página, podemos ver todos os passeios totais, viagens canceladas e receita do usuário </li> <li>
							O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li> <li>
							O administrador tem acesso para visualizar todos os registros e pesquisar os registros. </li> <li>
							A declaração geral tem o ID da reserva, Retirado, Descartado, Detalhes da solicitação, Comissões, Data datada, Status e Ganhos. </li> <li>
							Nisso, podemos obter a declaração anual dos detalhes da viagem. </li>
							",

							"admin.providertransfer" => "<h3> Liquidação de provedores </h3> <li> O administrador deve ter um cartão de débito a ser adicionado para ter uma transação com a conta do driver </li>
							<li> O motorista terá um valor de imposto e comissão de administrador em seus ganhos, para que ele possa solicitar um administrador para a transação </li>
							<li> O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> O administrador pode visualizar a transação, data e hora, nome do provedor, quantidade e ação. </li>
							<b> No modo de demonstração, não há opção para criar e enviar os assentamentos </b>
							",

							"admin.fleettransfer" => "<h3> Assentamentos de frota </h3> <li> O administrador deve ter um cartão de débito para fazer uma transação com a conta do motorista </li>
							<li> O motorista precisará pagar impostos e comissões para administrar a partir de seus ganhos, para que ele possa solicitar um administrador para a transação </li>
							<li> O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> O administrador pode visualizar a transação, data e hora, nome do provedor, quantidade e ação. </li>
							<b> No modo Demo, não há opção para criar e enviar os assentamentos </b>
							",

							"admin.transactions" => "<h3> Transações </h3> <li> O administrador pode visualizar tudo em uma página. </li>
							<li> O administrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> O superadministrador tem a opção de visualizar o ID da transação, data e hora, descrição, status e valor. </li>
							",

							"admin.user.review" => "<h3> Análise do usuário </h3> <li> O superadministrador pode visualizar todas as avaliações e classificações no aplicativo Web. </li>
							<li> O Superadministrador pode visualizar as classificações dos usuários e dos provedores separadamente. </li>
							<li> O Superadministrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> Na classificação de usuário e provedor, o ID da solicitação, o nome de usuário, o nome do provedor, o ID da solicitação, a classificação, a data e a hora e os comentários. </li>
							",

							"admin.provider.review" => "<h3> Revisão de fornecedores </h3> <li> O superadministrador pode visualizar todas as avaliações e classificações no aplicativo Web. </li>
							<li> O Superadministrador pode visualizar as classificações dos usuários e dos provedores separadamente. </li>
							<li> O Superadministrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> Na classificação de usuário e provedor, o ID da solicitação, o nome de usuário, o nome do provedor, o ID da solicitação, a classificação, a data e a hora e os comentários. </li>
							",

							"admin.requests.index" => "<h3> Histórico de solicitações </h3> <li> O Superadministrador pode visualizar todo o histórico de solicitações da viagem. </li>
							<li> O Superadministrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> ele é superadministrador, pode ver todos os detalhes como ID da reserva, nome de usuário, nome do provedor etc. </li>
							<li> O superadministrador pode acompanhar o status de todos os passeios do passageiro e do provedor </li>
							<b> No modo Demo, você não pode editar e excluir os registros. </b>
							",

							"admin.requests.scheduled" => "<h3> Passeios agendados </h3> <li> O Superadministrador pode visualizar todo o histórico agendado do passeio. </li>
							<li> O Superadministrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> Um superadministrador pode exibir todos os detalhes, como ID da reserva, nome de usuário, nome do provedor etc. </li>
							<li> O superadministrador edita e exclui a corrida programada. </li> 
							<b> No modo Demo, você não pode editar e excluir os registros. </b>
							",

							"admin.promocode.index" => "<h3> Mapa de calor </h3> <li> O administrador pode manter o código promocional e o código promocional pode ser adicionado manualmente no painel do administrador. </li>
							<li> O código promocional terá uma data de validade, valor do desconto e o código para inserir manualmente </li>
							<li> O código promocional não funcionará se expirar. </li>
							<li> O administrador pode editar e excluir o cupom do painel </li>
							<li> A lógica do código promocional será uma porcentagem acima do valor máximo. </li>
							<li> O Superadministrador apenas tem acesso para adicionar o código promocional. </li>
							<b> No modo Demo, você não pode adicionar, editar e excluir. </b>
							",

							"admin.service.index" => "<h3> Tipo de serviço </h3> <li> A lista de tipos de serviço pode ser gerenciada no painel do administrador </li>
							<li> O administrador pode adicionar, editar e excluir os tipos de serviço </li>
							<li> O administrador pode gerenciar a lógica de preços para cada tipo de serviço </li>
							<li> O administrador tem acesso para declarar preço base, preço à distância, preço por hora e lógica de preço para cada tipo de serviço </li>
							<li> O administrador pode adicionar o número 'N' de serviços no painel do administrador, onde ele obtém informações como nome do serviço, imagem do serviço, preço unitário, preço por hora e lógica para o tipo de serviço </li>
							<li> O administrador também pode inserir a capacidade e a descrição do assento para o tipo de serviço específico </li>
							<li> A lógica de preços de cada tipo de serviço será exibida e muda com base na lógica de preços que escolhemos </li>
							<li> O Superadministrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> O Superadministrador definiria o preço por Kms, o preço por minuto, a tarifa mínima, a tarifa básica, a comissão (%), as tarifas de cancelamento e as horas de pico para cada tipo de veículo. </li>
							<li> O administrador pode atualizar ou editar o serviço no painel. </li>
							<li> O administrador pode alterar seu preço base, preço por hora e lógica de preços para o tipo de serviço fornecido. </li>
							<b> No modo Demo, você não pode adicionar, editar e excluir </b>
							",

							"admin.document.index" => "<h3> Documentos </h3> <li> O superadministrador pode visualizar todos os documentos enviados pelo usuário e pelo provedor no aplicativo e no aplicativo Web. </li>
							<li> O superadministrador pode filtrar o documento de revisão na revisão do veículo e no motorista. </li>
							<li> O Superadministrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> O superadministrador pode pesquisar todos os documentos no módulo de pesquisa. </li>
							<li> O superadministrador pode adicionar os documentos para o motorista ou para o veículo e ele pode mapear a partir daqui. </li>
							<b> No modo Demo, você não pode adicionar, editar e excluir </b>
							",

							// "admin.notification.index" => "<h3> Mapa de calor </h3>",

							// "admin.reason.index" => "<h3> Mapa de calor </h3>",

							"admin.payment" => "<h3> Histórico de pagamentos </h3> <li> O superadministrador tem acesso total para exibir a página do histórico de pagamentos. </li>
							<li> O Superadministrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> Na página histórico de pagamentos, o administrador pode pesquisar todo o histórico no módulo de pesquisa. </li>
							<li> Na página do histórico de pagamentos, podemos visualizar o modo de pagamento, o status do pagamento, o status do pagamento etc. </li>
							",

							"admin.settings.payment" => "<h3> Configurações de pagamento </h3> <li> O administrador tem acesso completo às configurações de pagamento </li>
							<li> As configurações de pagamento incluem informações como alternância dinâmica do gateway de pagamento, meta de tarefa por dia, ponto de acionamento de pico, porcentagem de impostos, porcentagem de comissão e moeda. </li>
							<li> Um gateway de pagamento dinâmico é aquele em que o administrador pode ativar / desativar a opção e isso reflete no front end
							O ponto de disparo de pico e o ponto de pico mostram a demanda do provedor em uma área específica, se houver. </li>
							<li> Essas informações podem ser editadas e atualizadas usando o painel de administração </li>
							<li> O valor da comissão e do imposto deve ser especificado pelo administrador e o valor será adicionado à fatura do usuário </li>
							<b> No modo Demo, você não pode adicionar, editar e excluir. </b>
							",

							"admin.settings" => "<h3> Configurações do site </h3> <li> O superadministrador tem acesso para alterar todas as configurações </li>
							<li> As configurações do site são onde os detalhes completos do produto serão exibidos. </li>
							<li> As configurações do site incluem informações como uma loja de aplicativos, link da Play Store, distância de pesquisa, detalhes da resposta, SOS, email de contato, número de contato. </li>
							<li> O administrador pode optar pela opção manual e de transmissão, onde o administrador pode gerenciar a atribuição manual do projeto e a transmissão acontecerá automaticamente </li>
							<b> No modo de demonstração, você não pode adicionar, editar e excluir. </b> ",

							// "admin.role.index" => "<h3> Mapa de calor </h3>",

							// "admin.sub-admins.index" => "<h3> Mapa de calor </h3>",

							"admin.cmspages" => "<h3> Página do CMS </h3> <li> O superadministrador tem acesso à página do CMS. </li>
							<li> O superadministrador pode adicionar, editar e excluir páginas de conteúdo do CMS </li>
							<li> O Superadministrador pode alterar qualquer página no módulo CMS. </li>
							<b> No modo Demo, você não pode adicionar, editar e excluir. </b> ",

							"admin.help" => "<h3> Página de Ajuda </h3> <li> O superadministrador tem acesso à página de Ajuda. </li>
							<li> O superadministrador pode adicionar, editar e excluir páginas de conteúdo da Ajuda </li>
							<li> O Superadministrador pode alterar qualquer página no módulo Ajuda. </li>
							<b> No modo Demo, você não pode adicionar, editar e excluir. </b>
						   ",

							"admin.push" => "<h3> Mapa de calor </h3> <li> O superadministrador tem acesso à página de notificação por push. </li>
							<li> O Superadministrador pode exportar o arquivo como CSV ou Excel ou PDF. </li>
							<li> O administrador tem a opção chamada envio personalizado, onde algumas informações podem ser enviadas ao usuário ou driver. </li>
							<li> O envio personalizado pode ser enviado a um usuário específico ou a um usuário em um local específico ou a usuários ativos na última hora </li>
							<li> A mensagem chega ao usuário e ao driver como 'notificação por push' no aplicativo. </li>
							<b> No modo Demo, você não pode adicionar, editar e excluir. </b>
							",

							"admin.translation" => "<h3> Mapa de calor </h3> <li> O administrador pode gerenciar os detalhes da conta <li>
							<li> O administrador pode alterar os detalhes da conta usando este painel <li>
							<li> O administrador pode editar e atualizar os detalhes da conta <li>
							<b> No modo Demo, você não pode adicionar, editar e excluir. </b>
							",

							// "admin.lostitem.index" => "<h3> Mapa de calor </h3>",

							"admin.password" => "<h3> Alterar senha </h3> <li> O superadministrador tem acesso para alterar a senha nesta página. </li>
							<li> Somente o superadministrador pode editá-los, adicioná-los e excluí-los. </li>
							<b> No modo Demo, você não pode editar e excluí-lo. </b>
							",
						  ),

                            'user'=>array(
							"painel" => "<h3> Painel: </h3> Para solicitar uma carona, siga as etapas 
							<li> Forneça o local de retirada e retirada </li>
							<li> Escolha um serviço na lista de tipos de serviço </li>
							<li> Depois de concluído, você pode visualizar o ETA e a tarifa estimada pode ser </li> <li> visualizada e verificada </li>
							<li> O modo de pagamento e o código promocional podem ser especificados </li>
							<li> Você pode pedalar agora ou reservar a pedalada para mais tarde </li>
							<li> Uma vez escolhido o passeio, ele procurará um fornecedor próximo </li>
							",
							 "Notifications" => "<h3> Notificação </h3>
							 Se alguma informação for adicionada no painel do administrador em relação ao aplicativo, o usuário será notificado no gerenciador de notificações com uma imagem e uma descrição. ",
							"trips" => "<h3> Minhas viagens </h3> Neste painel, você pode ver o relatório detalhado do relatório de viagens anteriores.
							<li> Os detalhes incluem local de retirada e local de destino, redução de cálculo de tarifa, modo de pagamento </li>
							<h3> Disputa </h3> Um usuário pode levantar uma disputa sobre as viagens com uma descrição e ela será listada no painel de administração com os detalhes da viagem. O administrador verificará novamente a disputa levantada e alterará o status de acordo.
							<h3> Item perdido </h3> Um usuário pode solicitar ou entrar em contato com o administrador diretamente para perder os itens durante uma viagem. ",


							"coming / trips" => "<h3> Próximas viagens </h3> Nesta tela, você pode ver os detalhes das próximas viagens, ou seja, aquelas que o motorista aceitou

							<li> Os detalhes incluem local de retirada e local de destino, cálculo da tarifa, modo de pagamento, horário e data da reserva da agenda </li>
							<li> Se você deseja cancelar a solicitação, isso pode ser feito nos detalhes da solicitação </li>
							",
							"profile" => "<h3> Perfil </h3> Aqui, você pode editar os detalhes do perfil
							<li> Para editar, toque em editar e atualizar os detalhes como nome, foto do perfil e idioma </li>
							<li> O número e o email do celular não podem ser editados, pois esse é o campo exclusivo usado para fazer login com o aplicativo </li>
							",
							"change / password" => "<h3> Alterar senha </h3> Aqui você pode alterar a senha existente e atualizar a nova senha
							Para alterar a senha
							<li> Forneça senha antiga </li>
							<li> Digite a nova senha e confirme-a. </li>
							Como estamos no modo de demonstração, você não pode alterar a senha
							Mas no aplicativo, você pode alterar a senha e fazer login com as credenciais alteradas da senha
							",
							"payment" => "<h3> Pagamento </h3> O modo de pagamento disponível por padrão
							<li> Dinheiro </li>
							<li> Cartão </li>
							Podemos personalizar outros gateways de pagamento conforme sua exigência
							",
							"referral" => "<h3> Indique um amigo </h3> Um usuário pode indicar outro usuário / driver usando um código de referência que pode ser compartilhado via correio / SMS e o mesmo é usado durante o processo de inscrição para obter a contagem de referências e montante.
							A referência e o valor podem ser modificados pelo administrador ",

							"wallet" => "<h3> Carteira </h3> O pagamento pelo passeio pode ser pago através da carteira se o valor disponível
							Para recarregar a carteira
							<li> Especifique a quantidade a ser adicionada na carteira </li>
							<li> Adicione um cartão ou, se ele já existir, escolha um cartão e continue com a opção de adicionar dinheiro. </li>
							",
						   ),

						   'provider'=>array(
							"provider" => "<h3> Provedor </h3> Você se registrou com êxito como driver
							Mais algumas etapas precisam ser realizadas para concluir o perfil. Para ser motorista, há duas coisas que são obrigatórias em um perfil
							<li> Adicionar cartão (cartão de débito) </li>
							<li> Carregar documento </li>
							O motorista pode fazer o upload do documento e, depois disso, o cartão deve ser adicionado no perfil
							No modo Demo, se você efetuar login, não poderá visualizar os detalhes do cartão e do documento no aplicativo. No ambiente real, esses dois recursos são obrigatórios
							Você pode especificar a disponibilidade do driver usando a opção de alternância.
                            Se estiver online, você poderá receber a solicitação e, se estiver offline, não poderá receber uma solicitação.
							",
                            "provider/earnings" => "<h3> Ganhos do parceiro </h3> Nesta tela, você pode ver os ganhos do motorista por um dia
							Você pode ver o total de viagens concluídas, o número de viagens canceladas e a taxa de viagem aceita pelo motorista
							",
                            "provider/notifications"=> "<h3> Notificação </h3> Se alguma informação for adicionada no painel de administração referente ao aplicativo, o driver será notificado no gerenciador de notificações com uma imagem e uma descrição.",


							"provider/profile" => "<h3> Perfil </h3>
							<li> Você pode editar os detalhes fornecidos, como nome, foto do perfil, idioma, número de telefone, endereço, tipo de serviço, modelo de serviço e número do carro </li>
							<li> Você pode até mudar o número do carro, o modelo do carro </li>
						   ",
							"provider/documents" => "<h3> Gerenciar documentos </h3>
							Para carregar o documento
							<li> Carregar o documento especificado </li>
							<li> O formato do documento deve ser doc ou pdf ou imagem </li>
							<li> Após o upload, confirme o documento. O documento será </li> <li> revisado e aprovado pelo administrador </li>
							",
							"provider/location" => "<h3> Atualizar local </h3> Se o local estiver ativado na Web, o motorista poderá ser rastreado usando GPS e o local atual será exibido
							Se o local não estiver ativado, siga as etapas,
							<li> Toque no local da atualização </li>
							<li> Forneça o local em que você estava </li>
							<li> Atualize e continue </li>
							",
							"provider/wallet_transation" => "<h3> Transação da carteira </h3> O valor solicitado pelo administrador e o valor transacionado pelo administrador serão exibidos no histórico da carteira.",
							"provider/transfer" => "<h3> Transferir </h3>
							Se o driver precisar de quantia / transferência para o administrador, ele poderá solicitar / transferir quantia para / do painel de administração. Para solicitar / transferir valor.
							<li> Especifique a quantidade necessária / necessária para transferir </li>
							<li> Toque em transferência </li>
							<li> O administrador revisará e aprovará </li>
							",
							 "provider/referral" => "<h3> Indique um amigo </h3>
							Um driver pode indicar outro usuário / driver usando um código de referência que pode ser compartilhado via correio / SMS e o mesmo é usado durante o processo de inscrição para obter a quantidade e a quantidade de referências.
							A referência e o valor podem ser modificados pelo administrador ",

                            'user'=>array(
                            "painel" => "<h3> Painel: </h3> Para solicitar uma carona, siga as etapas
                            <li> Forneça o local de retirada e retirada </li>
                            <li> Escolha um serviço na lista de tipos de serviço </li>
                            <li> Depois de concluído, você pode visualizar o ETA e a tarifa estimada pode ser </li> <li> visualizada e verificada </li>
                            <li> O modo de pagamento e o código promocional podem ser especificados </li>
                            <li> Você pode pedalar agora ou reservar a pedalada para mais tarde </li>
                            <li> Uma vez escolhido o passeio, ele procurará um fornecedor próximo </li>
							",
                            "Notifications" => "<h3> Notificação </h3>
                            Se alguma informação for adicionada no painel do administrador em relação ao aplicativo, o usuário será notificado no gerenciador de notificações com uma imagem e uma descrição. ",
                            "trips" => "<h3> Minhas viagens </h3> Neste painel, você pode ver o relatório detalhado do relatório de viagens anteriores.
                            <li> Os detalhes incluem local de retirada e local de destino, redução de cálculo de tarifa, modo de pagamento </li>
                            <h3> Disputa </h3> Um usuário pode levantar uma disputa sobre as viagens com uma descrição e ela será listada no painel de administração com os detalhes da viagem. O administrador verificará novamente a disputa levantada e alterará o status de acordo.
                            <h3> Item perdido </h3> Um usuário pode solicitar ou entrar em contato com o administrador diretamente para perder os itens durante uma viagem. ",

                             "coming/trips" => "<h3> Próximas viagens </h3> Nesta tela, você pode ver os detalhes das próximas viagens, ou seja, aquelas que o motorista aceitou
                            
                            <li> Os detalhes incluem local de retirada e local de destino, cálculo da tarifa, modo de pagamento, horário e data da reserva da agenda </li>
                            <li> Se você deseja cancelar a solicitação, isso pode ser feito nos detalhes da solicitação </li>
                            ",
                            "profile" => "<h3> Perfil </h3> Aqui, você pode editar os detalhes do perfil
                            <li> Para editar, toque em editar e atualizar os detalhes como nome, foto do perfil e idioma </li>
                            <li> O número e o email do celular não podem ser editados, pois esse é o campo exclusivo usado para fazer login com o aplicativo </li>
                                                        ",
                             "change/password" => "<h3> Alterar senha </h3> Aqui você pode alterar a senha existente e atualizar a nova senha
                            Para alterar a senha
                            <li> Forneça senha antiga </li>
                            <li> Digite a nova senha e confirme-a. </li>
                            Como estamos no modo de demonstração, você não pode alterar a senha
                            Mas no aplicativo, você pode alterar a senha e fazer login com as credenciais alteradas da senha
                            ",
                            "payment" => "<h3> Pagamento </h3> O modo de pagamento disponível por padrão
                            <li> Dinheiro </li>
                            <li> Cartão </li>
                            Podemos personalizar outros gateways de pagamento conforme sua exigência
                            ",
                            "referral" => "<h3> Indique um amigo </h3> Um usuário pode indicar outro usuário / driver usando um código de referência que pode ser compartilhado via correio / SMS e o mesmo é usado durante o processo de inscrição para obter a contagem de referências e montante.
                            A referência e o valor podem ser modificados pelo administrador ",

                             "wallet" => "<h3> Carteira </h3> O pagamento pelo passeio pode ser pago através da carteira se o valor disponível
                            Para recarregar a carteira
                            <li> Especifique a quantidade a ser adicionada na carteira </li>
                            <li> Adicione um cartão ou, se ele já existir, escolha um cartão e continue com a opção de adicionar dinheiro. </li>
                                                        ",
						   ),

                                'provider' => array (
                            "provider" => "<h3> Provedor </h3> Você se registrou com êxito como driver
                            Mais algumas etapas precisam ser realizadas para concluir o perfil. Para ser motorista, há duas coisas que são obrigatórias em um perfil
                            <li> Adicionar cartão (cartão de débito) </li>
                            <li> Carregar documento </li>
                            O motorista pode fazer o upload do documento e, depois disso, o cartão deve ser adicionado no perfil
                            No modo de demonstração, se você fizer login, não poderá visualizar os detalhes do cartão e do documento no aplicativo. No ambiente real, esses dois recursos são obrigatórios
                            Você pode especificar a disponibilidade do driver usando a opção de alternância.
                                                        Se estiver online, você poderá receber a solicitação e, se estiver offline, não poderá receber uma solicitação.
                            ",
                            "provider/earnings" => "<h3> Ganhos do parceiro </h3> Nesta tela, você pode ver os ganhos do motorista por um dia
                            Você pode ver o total de viagens concluídas, o número de viagens canceladas e a taxa de viagem aceita pelo motorista
                            ",
                             "provider/Notifications" => "<h3> Notificação </h3> Se alguma informação for adicionada no painel de administração referente ao aplicativo, o driver será notificado no gerenciador de notificações com uma imagem e uma descrição.",

                            "provider/profile" => "<h3> Perfil </h3>
                            <li> Você pode editar os detalhes fornecidos, como nome, foto do perfil, idioma, número de telefone, endereço, tipo de serviço, modelo de serviço e número do carro </li>
                            <li> Você pode até mudar o número do carro, o modelo do carro </li>
						   ",
                            "provider/documents" => "<h3> Gerenciar documentos </h3>
                            Para carregar o documento
                            <li> Carregar o documento especificado </li>
                            <li> O formato do documento deve ser doc ou pdf ou imagem </li>
                            <li> Após o upload, confirme o documento. O documento será </li> <li> revisado e aprovado pelo administrador </li>
                            ",
                            "provider/location" => "<h3> Atualizar local </h3> Se o local estiver ativado na Web, o motorista poderá ser rastreado usando GPS e o local atual será exibido
                            Se o local não estiver ativado, siga as etapas,
                            <li> Toque no local da atualização </li>
                            <li> Forneça o local em que você estava </li>
                            <li> Atualize e continue </li>
							",
                            "provider/wallet_transation" => "<h3> Transação da carteira </h3> O valor solicitado pelo administrador e o valor transacionado pelo administrador serão exibidos no histórico da carteira.",
                            "provider/transfer" => "<h3> Transferir </h3>
                            Se o driver precisar de quantia / transferência para o administrador, ele poderá solicitar / transferir quantia para / do painel de administração. Para solicitar / transferir valor.
                            <li> Especifique a quantidade necessária / necessária para transferir </li>
                            <li> Toque em transferência </li>
                            <li> O administrador revisará e aprovará </li>
							",
                            "provider/referral" => "<h3> Indique um amigo </h3>
                            Um driver pode indicar outro usuário / driver usando um código de referência que pode ser compartilhado via correio / SMS e o mesmo é usado durante o processo de inscrição para obter a quantidade e a quantidade de referências.
                            A referência e o valor podem ser modificados pelo administrador ",
						),
                           ),
);

História:
Quando vai abrir o cadastro em uma instituição financeira (banco ou corretora de cambio) por exemplo abrir 1 cadastro na frente corretora, vamos abrir 1 cadastro lá, e preenchemos um formulário web, com autocomplete, e selects que fazem sentidos, mostrando as opções, e facilita a vida do usuário (nossos clientes, uma empresa que quer mandar um dinheiro pra fora, ou quer enviar um produto)

Ai esse cliente preencheria e mandaria os dados para as corretoras
No primeiro momento nós temos que assinar manualmente os formulários

Tem esses modelos ? Antonio vai me passar, e Erwin está olhando 
Como ele chama ? Xfdf
Como preencher ? Poc simples da simples mesmo ?
Limite tamanho de campo, campo que é checkbox, entender o modelo de formulários

CPF:
    33592510000154 Vale
    76535764000143 Oi
    42591651000143 Mc Donalds

Server:
    bash-4.2# lscpu 
    Architecture:          x86_64

Sites:
    ☐ Para instalar o pdftk
    https://www.linuxglobal.com/pdftk-works-on-centos-7/

Comandos:
    ☐ Para gerar os fields de um PDF (Melhor é a forma abaixo)
    ############### pdftk 1-BM.pdf dump_data_fields > oi.txt

    ☐ Para gerar automaticamente os templates
    pdftk originals/01-BM.pdf generate_fdf output templates/01-BM.fdf
    pdftk originals/2-BS2.PDF generate_fdf output templates/2-BS2.fdf

    ☐ Depois de substituir os campos no esquema acima, é só rodar o comando
    pdftk originals/01-BM.pdf fill_form 01-BM.fdf output output.pdf

    

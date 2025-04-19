# 📦 Projeto Laravel 12 + Stripe (Laravel Cashier)

Este é um projeto desenvolvido com **Laravel 12**, utilizando o pacote **Laravel Cashier** para integração com o **gateway de pagamentos Stripe**, permitindo:

- Gestão de planos de assinatura (Mensal, Anual e Tri-Anual)
- Pagamento via Stripe Checkout
- Geração de faturas
- Download da fatura em **formato PDF personalizado**, simulando um modelo brasileiro de **Nota Fiscal de Serviço (NFS-e)**

---

## ⚙️ Tecnologias Utilizadas

- **Laravel 12**
- **Laravel Cashier** (Stripe Billing)
- **Stripe API** (Checkout, Subscriptions, Invoices)
- **DOMPDF** (via `barryvdh/laravel-dompdf`) para geração de PDFs

---

## 🧩 Funcionalidades

- Autenticação direta (para testes locais)
- Escolha de plano com criptografia segura (`Crypt`)
- Pagamento via Stripe Checkout
- Painel com:
  - Nome do plano contratado
  - Valor
  - Data de expiração
  - Histórico de faturas
- Download da fatura em PDF com layout personalizado

---

## 💳 Planos Disponíveis

Os planos estão configurados no arquivo `.env` com os respectivos **Product ID** e **Price ID** fornecidos pelo Stripe:

-Mensal;
-1 Ano;
-3 Anos.

📄 PDF de Fatura
A fatura pode ser baixada via botão no painel do cliente. O layout simula uma NFS-e brasileira, contendo:

- Dados do cliente
- Descrição dos itens adquiridos
- Data da compra
- Valor total
- Informações do fornecedor

🧑‍💻 Desenvolvedor
Natanael Santos
Desenvolvedor PHP / Laravel



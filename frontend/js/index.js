'use strict'
import { getUsers, deleteUser, createUser, updateUser } from "./main.js";

$("#telefone, #telefone-edit").mask("(00) 0000-0000");
$("#celular, #celular-edit").mask("(00) 00000-0000");

const usuarios = await getUsers();

const dateFormatter = (dataOriginal) => {

let dataObj = new Date(dataOriginal);

    let day = dataObj.getDate() + 1;
    let month
if(dataObj.getMonth() > 8){
     month = dataObj.getMonth() + 1;   
}else{
     month = "0" + (dataObj.getMonth() + 1);  
}   

let year = dataObj.getFullYear();

return day + "/" + month + "/" + year;

}

const criarCard = (usuario) => {
    const card = document.createElement("tr");
    card.classList.add("table-contatos-tr-body");

    const nomeUsuario = document.createElement("td");
    nomeUsuario.textContent = usuario.nome;

    const dataNascimentoUsuario = document.createElement("td");
    dataNascimentoUsuario.textContent = dateFormatter(usuario.data_nascimento);

    const emailUsuario = document.createElement("td");
    emailUsuario.textContent = usuario.email;

    const celularUsuario = document.createElement("td");
    celularUsuario.textContent = usuario.celular;

    const acoesUsuario = document.createElement("td");
    acoesUsuario.classList.add("table-container-images");

    const editarUsuario = document.createElement("img");
    editarUsuario.src = "./img/editar.png";
    editarUsuario.alt = "Botão para editar usuário"
    editarUsuario.setAttribute("data-bs-toggle", "modal");
    editarUsuario.setAttribute("data-bs-target" ,"#editModal")
    editarUsuario.addEventListener('click', () => {
        
        let nome = document.getElementById("nome-edit");
        nome.value = usuario.nome

        let dataNascimento = document.getElementById("data-nascimento-edit");
        dataNascimento.value = usuario.data_nascimento;
        
        let email = document.getElementById("email-edit");
        email.value = usuario.email

        let profissao = document.getElementById("profissao-edit");
        profissao.value = usuario.profissao

        let celular = document.getElementById("celular-edit");
        celular.value = usuario.celular

        let telefone = document.getElementById("telefone-edit");
        telefone.value = usuario.telefone

        let whatsapp = document.getElementById("possui-whatsapp-edit");
        if(usuario.whatsapp == 1){
            whatsapp.checked = true
        }

        let notificacoesEmail = document.getElementById("notificacoes-email-edit");
        if(usuario.notificacoes_email == 1){
            notificacoesEmail.checked = true
        }

        let notificacoesSms = document.getElementById("notificacoes-sms-edit");
        if(usuario.notificacoes_sms == 1){
            notificacoesSms.checked = true
        }

        const buttonEditar = document.getElementById('button-editar')
        buttonEditar.addEventListener('click', () => {
            if (whatsapp.checked) {
              whatsapp = 1;
            } else {
              whatsapp = 0;
            }

            if (notificacoesEmail.checked) {
              notificacoesEmail = 1;
            } else {
              notificacoesEmail = 0;
            }

            if (notificacoesSms.checked) {
              notificacoesSms = 1;
            } else {
              notificacoesSms = 0;
            }

            nome.classList.remove("input-error");
            dataNascimento.classList.remove("input-error");
            email.classList.remove("input-error");
            profissao.classList.remove("input-error");
            telefone.classList.remove("input-error");
            celular.classList.remove("input-error");
            if (nome.value == "" || nome.value == null) {
              nome.classList.add("input-error");
            } else if (
              dataNascimento.value == "" ||
              dataNascimento.value == null
            ) {
              dataNascimento.classList.add("input-error");
            } else if (email.value == "" || email.value == null) {
              email.classList.add("input-error");
            } else if (profissao.value == "" || profissao.value == null) {
              profissao.classList.add("input-error");
            } else if (telefone.value == "" || telefone.value == null) {
              telefone.classList.add("input-error");
            } else if (celular.value == "" || celular.value == null) {
              celular.classList.add("input-error");
            } else {
              const usuarioJSON = {
                nome: nome.value,
                data_nascimento: dataNascimento.value,
                email: email.value,
                profissao: profissao.value,
                celular: celular.value,
                telefone: telefone.value,
                whatsapp: whatsapp,
                notificacoes_email: notificacoesEmail,
                notificacoes_sms: notificacoesSms,
              };

              updateUser(usuario.id, usuarioJSON);
              setTimeout(function () {
                location.reload();
              }, 1000);
            }
        })
    })

    const excluirUsuario = document.createElement("img");
    excluirUsuario.src = "./img/excluir.png";
    excluirUsuario.alt = "Botão para excluir usuário"
    excluirUsuario.setAttribute("data-bs-toggle", "modal");
    excluirUsuario.setAttribute("data-bs-target", "#deleteModal");
    excluirUsuario.addEventListener('click' , () => {
        const buttonExcluir = document.getElementById('button-excluir')
        buttonExcluir.addEventListener('click', () => {
            deleteUser(usuario.id);
            setTimeout(function () {
              location.reload();
            }, 1000);
        })
              
    })

    acoesUsuario.append(editarUsuario, excluirUsuario);
    card.append(
      nomeUsuario,
      dataNascimentoUsuario,
      emailUsuario,
      celularUsuario,
      acoesUsuario
    );
    return card;
}

const buttonCadastrar = document.getElementById("button-cadastrar");

buttonCadastrar.addEventListener('click', () =>{
    const nome = document.getElementById("nome");
    const dataNascimento = document.getElementById("data-nascimento");
    const email = document.getElementById("email");
    const profissao = document.getElementById("profissao");
    const celular = document.getElementById("celular");
    const telefone = document.getElementById("telefone");
    
    let whatsapp = document.getElementById("possui-whatsapp");
    if (whatsapp.checked) {
      whatsapp = 1;
    } else {
      whatsapp = 0;
    }

    let notificacoesEmail = document.getElementById("notificacoes-email");
    if (notificacoesEmail.checked) {
      notificacoesEmail = 1;
    } else {
      notificacoesEmail = 0;
    }

    let notificacoesSms = document.getElementById("notificacoes-sms");
    if (notificacoesSms.checked) {
      notificacoesSms = 1;
    } else {
      notificacoesSms = 0;
    }

    nome.classList.remove("input-error");
    dataNascimento.classList.remove("input-error");
    email.classList.remove("input-error");
    profissao.classList.remove("input-error");
    telefone.classList.remove("input-error");
    celular.classList.remove("input-error");

    if(nome.value == "" || nome.value == null){
        nome.classList.add('input-error')
    }else if(dataNascimento.value == "" || dataNascimento.value == null){
        dataNascimento.classList.add('input-error')
    }else if (email.value == "" || email.value == null) {
      email.classList.add("input-error");
    } else if (profissao.value == "" || profissao.value == null) {
      profissao.classList.add("input-error");
    } else if (telefone.value == "" || telefone.value == null) {
      telefone.classList.add("input-error");
    } else if (celular.value == "" || celular.value == null) {
      celular.classList.add("input-error");
    } else {
      const usuarioJSON = {
        nome: nome.value,
        data_nascimento: dataNascimento.value,
        email: email.value,
        profissao: profissao.value,
        celular: celular.value,
        telefone: telefone.value,
        whatsapp: whatsapp,
        notificacoes_email: notificacoesEmail,
        notificacoes_sms: notificacoesSms,
      };

      console.log(usuarioJSON);
      createUser(usuarioJSON);
      setTimeout(function () {
        location.reload();
      }, 1000);
    }
})

 const carregarCard = () => {
  const card = document.getElementById("container-usuarios");
  const cardsJSON = usuarios.dados.map(criarCard);
  console.log(cardsJSON);
  card.replaceChildren(...cardsJSON);
};

carregarCard()
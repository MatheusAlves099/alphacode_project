export const getUsers = async () => {
  const url = `http://localhost/alphacode_project/backend/index.php/usuarios`
  const response = await fetch(url);
  const dado = await response.json();
  return dado;
};

export function deleteUser(id) {
  const url = `http://localhost/alphacode_project/backend/index.php/usuarios/${id}`
  const options = {
    method: "DELETE",
  };

  fetch(url, options);
}

export const createUser = async ( usuario ) => {
    const url =
      "http://localhost/alphacode_project/backend/index.php/usuarios"
    const options = {
      headers: {
        "Content-Type": "application/json",
      },
      method: "POST",
      body: JSON.stringify(usuario),
    };

      fetch(url, options)
        .then((response) => {
          if (response.ok) {
            
            return response.json();
          } else {
            throw new Error("Erro ao fazer a solicitação");
          }
        })
        .then((data) => {
          console.log(data);
        })
        .catch((error) => {
          console.error(error);
        });
  }

  export const updateUser = async (id, usuario) => {
    const url = `http://localhost/alphacode_project/backend/index.php/usuarios/${id}`
    const options = {
      headers: {
        "Content-Type": "application/json",
      },
      method: "PUT",
      body: JSON.stringify(usuario),
    };

    fetch(url, options)
      .then((response) => {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error("Erro ao fazer a solicitação");
        }
      })
      .then((data) => {
        console.log(data);
      })
      .catch((error) => {
        console.error(error);
      });
  };




  
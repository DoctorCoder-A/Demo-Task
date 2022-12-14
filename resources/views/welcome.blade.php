<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authentication</title>
</head>
<body>
<form  method="POST" style="margin-left: 600px; padding: 20px" id="form">
    <label for="text">Text</label><br>
    <input id="text" name="text"><br>
    <label for="password">Token</label><br>
    <input class="password" name="token" ><br>
    <br>
    <label>GET
        <input type="radio" name="method" value="GET">
    </label>
    <label>POST
        <input type="radio" name="method" value="POST">
    </label>
    <button id="button-send">Send</button>
    <a href="/">Reload page</a>
</form>
<script>
    const form =  document.getElementById('form')
    form.addEventListener('submit', send)
    function send() {
        event.preventDefault();
        const formData = new FormData(form);
        let option
        if(formData.get('method')){
            option = handlerRequestMethod(formData.get('method'), formData.get('text'), formData.get('token'))
        }else{
            alert('you need select method (get or post)')
            return ;
        }
        console.log(option.url)
        console.log(option.parameters)
        sendRequest(option)
            .then(data => hadlerRespone(data))
            .catch(error => {
                console.log(error)
                alert('Failed!')
            })
    }
    function sendRequest(option){
        const headers = new Headers();
       return  fetch(option.url,option.parameters).then(response => {
            if(response.status === 200){
                return response.json()
            }else{
                return  false
            }
       })
    }
    function handlerRequestMethod(method, text, token){
        let url = '{{route('auth')}}'
        if(method === 'POST') {
            const body = {
                _token: '{{@csrf_token()}}',
                text: text,
                token: token
            }
            const headers = new Headers();
            headers.append("X-CSRF-TOKEN", "'{{csrf_token()}}'");
            headers.append("Content-Type", "application/json");

            return {
                parameters: {method,body: JSON.stringify(body), headers},url
            }
        }else{
            return {
                url:`${url}?text=${text}&token=${token}`,
                parameters: {method}
            }
        }
    }
    function hadlerRespone(data){
        let statusRespone
        console.log(data)
        console.log(data.status)
        if(data.status === 0){
            statusRespone = 'Failed'
        }else{
            statusRespone = 'Success'
        }
        alert(
            `
            Время выполнения:  ${data.working_time} seconds
            Затраченная память:  ${data.memory} bytes
            Статус: ${statusRespone}
            `
        )
    }
</script>
</body>
</html>

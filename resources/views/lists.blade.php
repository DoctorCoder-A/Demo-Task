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
<style>
    a{
        text-decoration: none;
    }
    ol{
        position: relative;
        left: 25%;
        margin-right: -50%;
    }
    li, #edit-name, #edit-text{
        width: 30%;
        padding: 5px;
        margin: 10px;
    }
    li{
        border: #1a202c solid 1px;
        border-radius: 15px;
    }

    .li,#edit-name, #edit-text {
        display: inline-block;
        list-style: none;
    }
    .delete-link{
        position: absolute;
        margin-top: 20px;
    }
    h1{
        text-align: center;
    }
    #edit-name, #edit-text{
        /*position: absolute;*/
        /*left: 13%;*/
        /*margin-right: -50%;*/
        width: 29%;
        height: 30px;
    }
    #edit-text{
        position: relative;
        left: -10px;
        top: -33px;
        width: 98%;
    }
    #edit-name{
        position: relative;
        left: -10px;
        top: -33px;
        width: 98%;
    }
</style>
<h1>List</h1>
    <ol>
        <div class="content">
        </div>
    </ol>
</body>
<script>
    getContent()
    function  buildElement(data){
        let parent = document.querySelector('.content')
        data.forEach((value)=>{
            let divParent = document.createElement('div')
            let li = document.createElement('li')
            let pName = document.createElement('p')
            let pText = document.createElement('p')
            let divDeleteLink =  document.createElement('div')
            let linkDelete = document.createElement('a')
            let divEditLink =  document.createElement('div')
            let linkEdit = document.createElement('a')

            divParent.className = 'text'
            li.className = 'li'
            pName.innerText = 'name: ' +value.name
            pName.dataset.name = value.id
            pText.innerText = 'text: ' +value.text
            pText.dataset.text = value.id
            divDeleteLink.className = 'li delete-link'
            linkDelete.innerText = 'delete'
            divEditLink.className = 'li edit link'
            linkEdit.setAttribute('id', 'edit-link')
            linkEdit.onclick = () => {showEditInput(value.id)}
            linkEdit.dataset.editId = value.id
            linkEdit.innerText = 'edit'

            divParent.append(li)
            li.append(pName)
            li.append(pText)
            divDeleteLink.append(linkDelete)
            divParent.append(divDeleteLink)
            divEditLink.append(linkEdit)
            divParent.append(divEditLink)
            parent.append(divParent)
        })
        return parent
    }
    function viewContent(data){
        const parent = document.querySelector('ol')
        parent.append(buildElement(data))
    }
    function getContent(){
        const url = '{{route('get.texts')}}'
        const method = 'POST'
        const body = {
            _token: '{{csrf_token()}}'
        }
        const parameters = {
            method,
            body
        }
        sendRequest({url, parameters})
            .then(data => viewContent(data))
            .catch(error => console.log(error))
    }
    function sendRequest(option){
        const headers = {
            'X-CSRF-TOKEN': '{{csrf_token()}}',
            'Content-Type': 'application/json'
        }
        option.parameters.headers = headers
       return  fetch(option.url, option.parameters)
            .then(response => {
                if (response.status === 200) {
                    return response.json()
                } else {
                    console.log('error!')
                    console.log(response.status)
                }
            })
    }
    function edit(id, type=1){
        let data = {}
        if(type === 1){
            data.name = document.querySelector(`[data-edit-name="${id}"]`).value
         }else if(type === 2){
            data.text = document.querySelector(`[data-edit-text="${id}"]`).value
        }

        const body = JSON.stringify({
            data,
            id,
            _token: '{{csrf_token()}}',
            _method: 'PUT'
        })
        const url = '{{route('edit.texts')}}'
        const method = 'POST'
        sendRequest({url, parameters: {method, body}})
            .then(response => {
                let element = document.querySelector(`[data-${response.element}="${response.id}"]`)
                element.innerText = response.element+': ' + response[response.element]
                showEditInput(response.id)
            })
            .catch(error => console.log(error))
    }
    function showEditInput(id){
        buildEditInput(id)
    }

    function buildEditInput(id) {
        const name = document.querySelector(`[data-name="${id}"`)
        const text = document.querySelector(`[data-text="${id}"`)

        const nameInput = document.querySelector('#edit-name') ?? null
        const textInput = document.querySelector('#edit-text') ?? null

        if (!nameInput && !textInput) {
            const inputName = document.createElement('input')
            const inputText = document.createElement('input')

            inputName.setAttribute('name', 'name')
            inputName.setAttribute('placeholder', 'name')
            inputName.setAttribute('value', name.innerText.replace('name:', ''))
            inputName.setAttribute('id', 'edit-name')
            inputName.dataset.editName = id
            inputName.onchange = () => {
                edit(id, 1)
            }
            inputText.setAttribute('name', 'text')
            inputText.setAttribute('placeholder', 'text')
            inputText.dataset.editText = id
            inputText.setAttribute('value', text.innerText.replace('text:', ''))
            inputText.setAttribute('id', 'edit-text')
            inputText.onchange = () => {
                edit(id, 2)
            }
            name.append(inputName)
            text.append(inputText)
            document.querySelector(`[data-edit-id="${id}"]`).innerText = 'close'
        } else if (!nameInput || textInput) {
            nameInput.remove()
            textInput.remove()
            document.querySelector(`[data-edit-id="${id}"]`).innerText = 'edit'
        }
    }
</script>
</html>

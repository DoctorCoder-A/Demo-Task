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
    li{

        border: #1a202c solid 1px;
        border-radius: 15px;
        width: 30%;
        padding: 5px;
        margin: 10px;
    }

    .li {
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
</style>
<h1>List</h1>
    <ol>
        <div class="content">
        </div>
    </ol>
</body>
<script>
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
            pName.innerText = value.name
            pText.innerText = value.text
            divDeleteLink.className = 'li delete-link'
            linkDelete.innerText = 'delete'
            divEditLink.className = 'li edit link'
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
    function view(data){
        const parent = document.querySelector('ol')
        parent.append(buildElement(data))
    }
    getContent()
    function getContent(){
        const url = '{{route('get.texts')}}'
        const method = 'POST'

        sendRequest({url,method})
            .then(data => view(data))
            .catch(error => console.log(error))
    }
    function sendRequest(option){
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
</script>
</html>

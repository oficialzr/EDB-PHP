$(function() {

    const forms = Array.from(document.querySelectorAll('form'))

    const button = document.getElementById('form-choice')

    place = $('#place')
    role = document.getElementById('role')

    button.addEventListener('change', (e)=>{
        // e.target
        for (j of forms) {
            j.reset()
            if (e.target.value == forms.indexOf(j)+1) {
                $(j).show()
            } else {
                j.firstElementChild.firstElementChild.children[1].value = ''
                let event = new Event('change')
                j.firstElementChild.firstElementChild.children[1].dispatchEvent(event)
                $(j).hide()
            }
        }
    })

    forms.forEach((f)=>{
        $(f).submit(function(e){
            const id = document.getElementById('id').textContent
            $.post(`/app/controllers/add-addr.php?id=${id}`, $(this).serialize(), function(data){
                const data_new = JSON.parse(data)
                const dataR = data_new['data']
                const names = data_new['names']
                addInfo(dataR, dataR['header'], names)
                otherForm.reset()
            })
            e.preventDefault();
        });
    })
    
    const placeholder_for_data = document.getElementById('placeholder_for_data')
    placeholder_for_data.insertAdjacentHTML('afterend', `<div id="added-data" class="added-data"></div>`)
    place_for_data = document.getElementById('added-data')

    function addInfo(data, header, names) {
        place_for_data.insertAdjacentHTML('beforeend', `<h2>${header}</h2>`)
        place_for_data.insertAdjacentElement('beforeend', document.createElement('table'))
        place_for_data.lastElementChild.style.width = '50%'
        place_for_data.lastElementChild.className = 'collapse-border'
        for (i in data) {
            if (i != 'header') {
                place_for_data.lastElementChild.insertAdjacentHTML('beforeend', `<tr><td>${names[i]}</td><td>${data[i]}</td></tr>`)
            }
        }
    }    

}());
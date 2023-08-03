$(function(){
    let role = ''
    if (document.getElementById('workForm')) {
        role = 'workForm'
    } else {
        role = 'event'
    }

    const selections = Array.from(document.getElementById(role).querySelectorAll('select'))

    const q = document.getElementById(role).querySelectorAll('select')
    
    for (index=0;index<q.length;index++) {
        value = q[index]
        if (value.name != 'entity') {
            value.disabled = true
        }
        value.addEventListener('change', (e)=>{
            const name = e.target.name

            if (name != 'repr') {

                const value = e.target.value

                let key = e.target
                for (i of selections.slice(selections.indexOf(key))) {
                    if (key.nextElementSibling.type === 'select-one') {
                        key.nextElementSibling.disabled = true
                        key.nextElementSibling.value = ''
                        key = i
                    }
                }

                $.get('app/helper/set-adaptive.php', {'name': name, 'value': value}, function(data){
                    data = JSON.parse(data);
                    if (e.target.nextElementSibling.type === 'select-one') {
                        if (data['data'] == '500') {
                            e.target.nextElementSibling.disabled = true
                        } else {
                            e.target.nextElementSibling.disabled = false
                        }
                    }
                    try {
                        key = e.target.nextElementSibling;
                        for (i of Array.from(key.children).slice(1)) {
                            if (data['data'].includes(i.value)) {
                                $(i).show()
                            } else {
                                $(i).hide()
                            }
                        }
                    } catch (error) {
                        
                    }
                })
            }
        })
    }
}());
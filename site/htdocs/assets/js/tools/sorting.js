$(function() {

    // COUNTER

    counter = $('#counter')
    updateCounter()


    // PAGINATE

    function paginate() {
        Array.from(document.querySelectorAll('#pagination-ul li')).forEach((e)=>{
            e.removeEventListener('click', btE)
        })

        a = document.getElementsByClassName('dgt')
        if (a) {
            for (i of Array.from(a)) {
                i.remove()
            }
        }
        
        let crP = 0
        const aD = $('tr:not(.header-table)')
        const c = parseInt((aD.length - 1) / 30) + 1
        const bP = document.getElementById('pagination-ul')

        const lD = gL(Array.from(aD))
        wrB()
        haD()

        let crPC = $('.dgt')[0]
        crPC.style.backgroundColor = 'gainsboro'



        function btE(n) {
            k = 0
            switch (n.target.id) {
                case 'first':
                    k = 0
                    break;
                case 'previous':
                    k = crP - 1
                    break;
                case 'next':
                    k = crP + 1
                    break;
                case 'last':
                    k = ($('.dgt').length - 1)
                    break;
            }
            $('.dgt')[k].dispatchEvent(new Event('click'))
        }

        function haD() {
            $('#loading').show()
            for (l of aD.slice(30, aD.length)) {
                $(l).hide()
            }
            setTimeout(()=>{
                $('#loading').hide()
            }, 500)

        }

        function gL(d) {
            const l = new Array()
            for (i = 0; i < c; i++) {
                l.push(d.slice(30*i, 30*(i+1)))
            }
            return l
        }

        function wrB() {
            for (i = 1; i <= c; i++) {
                k = bP.insertAdjacentHTML('beforeend', `<li class='dgt'>${i}</li>`)
            }
            Array.from(document.getElementsByClassName('dgt')).forEach((e)=>{
                e.addEventListener('click', gtP)
            })
        }

        function gtP(f) {
            const b = f.target.innerText - 1
            crPC.style.backgroundColor = 'white'
            crPC = f.target
            f.target.style.backgroundColor = 'gainsboro'
            pgD(b)
            crP = b
        }

        function pgD(b) {
            for (i=0; i < 30; i++) {
                $(lD[crP][i]).hide()
                $(lD[b][i]).show()
            }
        }
    }

    paginate()
    
    // document.getElementById().insertAdjacentHTML
    // SORT

    const tbody = $('#tbodyTable')

    const dataList = tbody.find('tr')

    // document.getElementById('sortId').addEventListener('change', sortIt)
    



    // FILTER

    
    let filterContent = Array.from(document.getElementById('filter').querySelectorAll('select'))

    if (document.getElementById('filter-person')) {
        filterContent = filterContent.slice(2)
    } else {
        filterContent = filterContent.slice(1)
    }

    filterContent.forEach((value)=>{
        if (!['entity', 'type', 'sex', 'role'].includes(value.name)) {
            if (value.parentElement.previousElementSibling.lastElementChild.value != '') {

            } else {
                value.disabled = true
            }
        }
        
        value.addEventListener('change', (e)=>{
            const name = e.target.name
            const value = e.target.value

            key = e.target

            for (i of filterContent.slice(filterContent.indexOf(key))) {
                if (key.parentElement.nextElementSibling.lastElementChild.type == 'select-one') {
                    key.parentElement.nextElementSibling.lastElementChild.disabled = true
                    key.parentElement.nextElementSibling.lastElementChild.value = ''
                    key = i
                }
            }
            selectRight(e.target, name, value)
        });
        selectRight(value, value.name, value.value)
    })

    document.getElementById('filter-delete').addEventListener('click', (event)=>{
        for (i of document.getElementsByClassName('filter-content')[0].querySelectorAll('select')) {
            i.selectedIndex = 0
        };
        document.getElementById('id_search_input').value = ''
    })


    const data_all = $('tr:not(.header-table)');
    const inputSearch = document.getElementById('id_search_input')
    const delSpan = document.getElementById('delete-search');
    const srchBtn = document.getElementById('search-button-person')

    $(inputSearch).on('keypress', (i)=>{
        if (i.which == 13) {
            srchBtn.dispatchEvent(new Event('click'))
        }
    })

    if (inputSearch.value != '') {
        delSpan.style.display = 'block'
    }



    // DATE ZONE 

    document.getElementById('check-date').addEventListener('click', ()=>{
        setDateZone()
    })

    document.getElementById('del-date').addEventListener('click', ()=>{
        document.getElementById('from_date').value = ''
        document.getElementById('to_date').value = ''
        showAllData()
    })

    // До сегодняшней даты ++ 



    // SEARCH

    delSpan.addEventListener('click', ()=>{
        inputSearch.value = ''
        $(delSpan).toggle()
    });

    inputSearch.addEventListener('input', (value)=>{
        if (value.target.value != '') {
            delSpan.style.display = 'block'
        } else {
            delSpan.style.display = 'none'
        }
    })

    let c = ''

    if (document.getElementById('add-person')) {
        c = 'fio'
    } else {
        c = 'desc'
    }

    srchBtn.addEventListener('click', (e)=>{
        p = inputSearch.value.split(' ')
        for (i of data_all) {
            $(i).show()
        }
        for (i of data_all) {
            for (m of p) {
                if ($(i.querySelector(`#${c}`)).text().toLowerCase().includes(m.toLowerCase())) {

                } else {
                    $(i).hide()
                    break
                }
            }
        }
        updateCounter()
    })


    // FUNCTIONS


    function showAllData() {
        for (line of data_all) {
            $(line).show()
        }
    }

    function selectRight(e, name, value) {
        $.get('app/helper/set-adaptive.php', {'name': name, 'value': value}, function(data){
            data = JSON.parse(data);
            if (e.parentElement.nextElementSibling.lastElementChild.type == 'select-one') {
                if (data['data'] == '500') {
                    e.parentElement.nextElementSibling.lastElementChild.disabled = true
                } else {
                    e.parentElement.nextElementSibling.lastElementChild.disabled = false
                }
            }
            try {
                key = e.parentElement.nextElementSibling.lastElementChild;
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

    document.getElementById('sortId').addEventListener('change', (e)=>{
        const req = e.target[e.target.selectedIndex].id;
        const h = window.location.href;
        if (h.includes('sort')) {
            a = h.split('=')
            a = a.slice(0, a.length-1).join('=') + "=" + req;
            window.location.replace(a);
            die();
        }
        a = h.split('.');
        if (a[a.length-1] != 'php') {
            a = a.join('.') + `&sort=${req}`
        } else {
            a = a.join('.') + `?sort=${req}`
        }
        window.location.replace(a);
    })


    function updateCounter(count=null) {
        if (count) {
            counter.text(count)
            return
        }
        const currentData = $('tr:visible:not(.header-table)').length
        counter.text(currentData)
    }

    function setDateZone() {
        const i = new Date(document.getElementById('from_date').value)
        const j = new Date(document.getElementById('to_date').value)
        if (i.getFullYear() > 1900 & j.getFullYear() <= new Date().getFullYear()) {
            for (l of data_all) {
                t = $(l).find('#date').text().split('.');
                tD = new Date(t[2], t[1]-1, t[0])
                if (tD > i & tD < j) {
                    $(l).show()
                } else {
                    $(l).hide()
                }
            }
        }
        updateCounter()
    }

}());


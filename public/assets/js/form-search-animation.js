

function show_search(yesno)
{
    if(yesno == true){
        document.querySelector('.form-search').classList.remove('hidden')
        document.querySelector('.form-search').classList.add('active')
        document.querySelector('.close').classList.add('show')
        document.querySelector('.search').classList.add('hidden')
        $(document).on('click', '.search', function(){ $('#parent').prop('class', 'hidden') })
        $(document).on('click', '.search', function(){ $('#mb-parent').removeClass('hidden') })
        $(document).on('click', '.search', function(){ $('#mb-parent').addClass('show') })
    }
    else if(yesno == false){
        document.querySelector('.form-search').classList.remove('active')
        document.querySelector('.form-search').classList.add('hidden')
        document.querySelector('.close').classList.remove('show')
        document.querySelector('.search').classList.remove('hidden')
    }
}

document.addEventListener("DOMContentLoaded", function(){

    document.querySelector('.search').addEventListener('click', function(e){
        show_search(true)
    })

    document.querySelector('.close').addEventListener('click', function(e){
        show_search(false)
    })
})

// document.getElementById('search').addEventListener('click', function(e){
//     show_search(true)
// })
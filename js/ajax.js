var publications = document.querySelector('.publications');
var more_disciplines = document.getElementById('more_disciplines_button');


function loadPosts(btn) {
    let page = parseInt(btn.getAttribute('data-page'));
    page++;

    let max_page = parseInt(btn.getAttribute('data-max-page'));
    let url = 'more_posts.php?page=' + page + '&discipline_id=' + btn.getAttribute('data-disc_id');
    fetch(url)
        .then(response => response.text())
        .then((result) => {
            btn.insertAdjacentHTML('beforeBegin', result);
            btn.setAttribute('data-page', page.toString());
            if (page == max_page) {
                btn.remove();
            }
        })
        .catch(error => console.log(error));


}


function loadDisciplines() {

    let page = parseInt(more_disciplines.getAttribute('data-page'));
    page++;

    let max_page = parseInt(more_disciplines.getAttribute('data-max-page'));
    let url = 'more_disciplines.php?page=' + page;
    fetch(url)
        .then(response => response.text())
        .then((result) => {
            publications.insertAdjacentHTML('beforeend', result);
            more_disciplines.setAttribute('data-page', page.toString());
            console.log(result);
            if (page == max_page) {
                more_disciplines.remove();
            }
        })
        .catch(error => console.log(error));
}

more_disciplines.onclick = function () {
    loadDisciplines();
}
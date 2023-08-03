$(function () {
	new Autocomplete('#autocomplete', {
        search: input =>{
            const url = `/app/helper/search.php?type=${input}`
            return new Promise(resolve => {
                fetch(url)
                .then(response => response.json())
                .then(data => {
                    resolve(data.data.slice(0, 3))
                })
            })
        },
    });
}());

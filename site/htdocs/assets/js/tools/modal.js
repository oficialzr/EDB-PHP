$(function(){
	const modal = document.getElementById('dark');
	document.getElementById('add-info').addEventListener('click', function() {
		modal.style.display = 'block';
	})
	document.getElementById('close-modal').addEventListener('click', function() {
		modal.style.display = 'none';
	})
	document.getElementById('info-post').addEventListener('submit', function(e) {
		const desc = document.getElementById('short_desc')
		if (desc.value.length >= 30) {
			desc.style.borderWidth = '1px';
			desc.style.borderColor = 'red';
			desc.style.borderStyle = 'solid';
			e.preventDefault();
			setTimeout(()=>{
				desc.style.borderColor = 'black';
				desc.style.borderWidth = '1px';
			}, 1000)
		}
		
	})
}());
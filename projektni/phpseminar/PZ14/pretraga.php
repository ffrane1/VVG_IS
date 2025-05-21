<?php 
	print '
	<h1>PRETRAGA</h1>
		<label for="kategorije">Odaberi kategoriju:</label>
		<select id="kategorije">
		<option value="">-- Odaberi --</option>
		</select>

		<label for="filter-cijena">Filtriraj po cijeni:</label>
		<select id="filter-cijena">
		<option value="">-- Odaberi --</option>
		<option value="manje20">Manje od 20 $</option>
		<option value="20do50">20 - 50 $</option>
		<option value="vise50">Više od 50 $</option>
		</select>

		<ul id="proizvodi-lista"></ul>

		</div>
	'
?>
<script type="text/javascript">

	const kategorijeSelect = document.getElementById('kategorije');
	const cijenaSelect = document.getElementById('filter-cijena');
	const lista = document.getElementById('proizvodi-lista');

	let sviProizvodi = [];

	// 1. Dohvati kategorije i popuni <select>
	fetch('https://api.escuelajs.co/api/v1/categories')
		.then(res => res.json())
		.then(kategorije => {
		kategorije.forEach(kategorija => {
			const opcija = document.createElement('option');
			opcija.value = kategorija.id;
			opcija.textContent = kategorija.name;
			kategorijeSelect.appendChild(opcija);
		});
		});

	// 2. Reagiraj na promjene u oba <select> elementa
	kategorijeSelect.addEventListener('change', provjeriFiltere);
	cijenaSelect.addEventListener('change', provjeriFiltere);

	function provjeriFiltere() {
		const kategorijaId = kategorijeSelect.value;
		const cijenaFilter = cijenaSelect.value;

		if (kategorijaId && cijenaFilter) {
		// Ako su oba odabrana, dohvatimo proizvode iz kategorije
		fetch(`https://api.escuelajs.co/api/v1/categories/${kategorijaId}/products`)
			.then(res => res.json())
			.then(proizvodi => {
			sviProizvodi = proizvodi;
			const filtrirani = filtrirajPoCijeni(sviProizvodi, cijenaFilter);
			prikaziProizvode(filtrirani);
			})
			.catch(error => console.error("Greška kod dohvaćanja proizvoda:", error));
		} else {
		lista.innerHTML = ""; // Prazni listu ako filteri nisu potpuni
		}
	}

	function filtrirajPoCijeni(proizvodi, filter) {
		switch (filter) {
		case 'manje20':
			return proizvodi.filter(p => p.price < 20);
		case '20do50':
			return proizvodi.filter(p => p.price >= 20 && p.price <= 50);
		case 'vise50':
			return proizvodi.filter(p => p.price > 50);
		default:
			return proizvodi;
		}
	}

	function prikaziProizvode(proizvodi) {
		lista.innerHTML = '';
		if (proizvodi.length === 0) {
		lista.innerHTML = '<li class="empty-message">Nema proizvoda za odabrani filter.</li>';
		return;
		}

		proizvodi.forEach(p => {
		const item = document.createElement('li');
		item.innerHTML = `
			<strong>${p.title}</strong> - ${p.price} $
			<br>
			<img src="${p.images[0]}" alt="${p.title}">
		`;
		lista.appendChild(item);
		});
	}
</script>
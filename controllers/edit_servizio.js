function onPrice()
{
	let p = document.getElementById("price").value;
	if(!/^[0-9]{1,5}(,[0-9]{1,2})?$/.test(p))
	{
		document.getElementById('price').setAttribute('aria-invalid', true);
		document.getElementById('price').setAttribute('aria-describedby', 'price-error');

		document.getElementById('Salva').setAttribute('aria-disabled', true);
		document.getElementById('Salva').classList.add('disabled');
		document.getElementById("price-error").innerText= p=="" ? "Campo obbligatorio" : "Formato prezzo non valido. Formato corretto: interi,decimale.";
	}
	else
	{
		document.getElementById('price').setAttribute('aria-invalid', false);
		document.getElementById('price').removeAttribute('aria-describedby');
		
		document.getElementById('Salva').setAttribute('aria-disabled', false);
		document.getElementById('Salva').classList.remove('disabled');
		document.getElementById("price-error").innerText="";
	}
}

function onName()
{
	let p = document.getElementById("name").value;
	if(!/^[a-zA-Z áéíóúàèìòù\']+$/.test(p))
	{
		document.getElementById('name').setAttribute('aria-invalid', true);
		document.getElementById('name').setAttribute('aria-describedby', 'name-error');

		document.getElementById('Salva').setAttribute('aria-disabled', true);
		document.getElementById('Salva').classList.add('disabled');
		document.getElementById("name-error").innerText= p=="" ? "Campo obbligatorio" : "Caratteri non validi presenti. Usa solo lettere.";	
	}
	else
	{
		document.getElementById('name').setAttribute('aria-invalid', false);
		document.getElementById('name').removeAttribute('aria-describedby');

		document.getElementById('Salva').setAttribute('aria-disabled', false);
		document.getElementById('Salva').classList.remove('disabled');
		document.getElementById("name-error").innerText="";
	}
}

function onDescription()
{
	let p = document.getElementById("description").value;
	if(!/^[a-zA-Z \.\,\;áéíóúàèìòù\']+$/.test(p))
	{
		document.getElementById('description').setAttribute('aria-invalid', true);
		document.getElementById('description').setAttribute('aria-describedby', 'description-error');

		document.getElementById('Salva').setAttribute('aria-disabled', true);
		document.getElementById('Salva').classList.add('disabled');
		document.getElementById("description-error").innerText= p=="" ? "Campo obbligatorio" : "Caratteri non validi presenti. Usa solo lettere, punti e virgole.";	
	}
	else
	{
		document.getElementById('description').setAttribute('aria-invalid', false);
		document.getElementById('description').removeAttribute('aria-describedby');

		document.getElementById('Salva').setAttribute('aria-disabled', false);
		document.getElementById('Salva').classList.remove('disabled');
		document.getElementById("description-error").innerText="";
	}
}

function preventSubmit(event)
{
	arr = document.getElementsByTagName('input');
	for(let a=0; a<arr.length; a++)
	{
		if(arr[a].getAttribute('aria-invalid')=="true")
		{
			event.preventDefault();
			arr[a].focus();
			break;
		}
	}
	if(document.getElementById("description").getAttribute('aria-invalid') == "true")
	{
		event.preventDefault();
		document.getElementById("description").focus();
	}
}
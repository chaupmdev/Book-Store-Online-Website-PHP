const locs = document.querySelectorAll('.loc');
const showAll = document.querySelector('.showAll');
let dem = locs.length;
locs.forEach(loc => loc.addEventListener("click", () => {
    if (!loc.checked) {
        dem--
        showAll.checked = false
    }
    else {
        dem++
        if (dem == locs.length)
            showAll.checked = true
    }
}))
showAll.addEventListener("click", () => {
	var trangthais = document.querySelectorAll('.trangthai')
    if (showAll.checked)
		{
			dem = locs.length;
        	locs.forEach(loc => loc.checked = true)
			trangthais.forEach(tt=>tt.hidden=false)
		}
    else
		{
			dem = 0;
        	locs.forEach(loc => loc.checked = false)
			trangthais.forEach(tt=>tt.hidden=true)
		}
})

locs.forEach(loc=>loc.addEventListener("click",()=>{
	let items = document.querySelectorAll("."+loc.id);
	items.forEach(item=>item.hidden =!item.hidden);
}))

function taoClassLoai(trangthai)
{
	for(var i = 0;i<locs.length;i++)
		if(trangthai == locs[i].value)
			return locs[i].id;
}

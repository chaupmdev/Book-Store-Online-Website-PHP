function loadNutPhanTrang(sl,vtPage,pagination)
{			
	let s='';
	let pageAvaiable = [1,2,vtPage-1, vtPage, vtPage+1, sl-1,sl] ;					  
	if(vtPage>1)
		s+=`<li class="page-item "><a onClick="LoadDatas(${vtPage-1},${sl})" class="page-link" >Trước</a></li>`;
	for(var i = 1;i<=sl && sl>1;i++)	
		if(pageAvaiable.indexOf(i)!=-1)																	
			s+=`<li class="page-item ${ i== vtPage? 'active':''} " id="pape${i}"><a ${i!=vtPage? `onClick="LoadDatas(${i},${sl}`:''})" class="page-link">${i}</a></li>`;							
		else					   						  
			if(i+2==vtPage)								
				s+=`<li class="page-item" id="pape${i}"><a onClick="LoadDatas(${i},${sl})" class="page-link">...</a></li>`;													
			else if(i-2==vtPage)								
				s+=`<li class="page-item" id="pape${i}"><a onClick="LoadDatas(${i},${sl})" class="page-link">...</a></li>`;															   
	if(sl>1 && vtPage <sl)
		s+=`<li class="page-item"><a onClick="LoadDatas(${vtPage+1},${sl})" class="page-link" >Sau</a></li>`;
	pagination.innerHTML = s;
}
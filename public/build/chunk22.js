import{k as m,h as x,o as l,f as n,b as s,F as y,s as C,i as _,v as k,n as w,d as I,t as N,g as h,l as V}from"./app.js";const M={key:0,class:"fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"},S={class:"bg-white p-6 rounded-lg shadow-lg"},A=["id","value","disabled"],B=["for"],D={key:0},j={__name:"ShareListModal",props:{listId:Number,activeConnections:Array,sharedContacts:Array,ownerId:Number,currentUserId:Number},emits:["close","shared"],setup(p,{emit:b}){const r=p,d=b,c=m(!0),a=m([]),i=t=>r.sharedContacts?r.sharedContacts.includes(t):!1,f=x(()=>r.activeConnections.filter(t=>t.id!==r.ownerId&&t.id!==r.currentUserId)),g=async()=>{if(a.value.length>0)try{await V.post(route("share-list"),{listId:r.listId,contacts:a.value}),d("shared"),u()}catch(t){console.error("Erreur lors du partage de la liste:",t)}else alert("Veuillez sélectionner au moins un contact.")},u=()=>{c.value=!1,d("close")};return(t,o)=>c.value?(l(),n("div",M,[s("div",S,[o[1]||(o[1]=s("h4",{class:"text-lg font-semibold mb-4"},"Partager la liste avec :",-1)),s("ul",null,[(l(!0),n(y,null,C(f.value,e=>(l(),n("li",{key:e.id,class:"flex items-center mb-2"},[_(s("input",{type:"checkbox",id:"contact-"+e.id,value:e.id,"onUpdate:modelValue":o[0]||(o[0]=v=>a.value=v),disabled:i(e.id)},null,8,A),[[k,a.value]]),s("label",{for:"contact-"+e.id,class:w(["ml-2",{"text-gray-400":i(e.id)}])},[I(N(e.name)+" ",1),i(e.id)?(l(),n("span",D,"(Déjà partagé)")):h("",!0)],10,B)]))),128))]),s("button",{onClick:g,class:"mt-4 px-4 py-2 bg-green-500 text-white rounded"}," Confirmer "),s("button",{onClick:u,class:"mt-4 px-4 py-2 bg-red-500 text-white rounded ml-2"}," Annuler ")])])):h("",!0)}};export{j as _};

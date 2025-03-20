import{h as y,i as _,v as h,o as n,f as v,C as k,c,w as d,a,u as t,m as V,b as o,t as B,g as p,e as C,P,d as f,n as $}from"./app-UflIzx5p.js";import{_ as S}from"./GuestLayout-DNf6Sd9_.js";import{_ as b,a as g,b as w}from"./TextInput-D9-IPhIL.js";import{P as j}from"./PrimaryButton-CyGQfHPb.js";import{_ as q}from"./_plugin-vue_export-helper-DlAUqK2U.js";/* empty css            */import"./ApplicationLogo-BEQ8lapF.js";const L=["value"],M={__name:"Checkbox",props:{checked:{type:[Array,Boolean],required:!0},value:{default:null}},emits:["update:checked"],setup(l,{emit:s}){const i=s,u=l,e=y({get(){return u.checked},set(r){i("update:checked",r)}});return(r,m)=>_((n(),v("input",{type:"checkbox",value:l.value,"onUpdate:modelValue":m[0]||(m[0]=x=>e.value=x),class:"rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"},null,8,L)),[[h,e.value]])}},N={class:"flex items-center justify-center min-h-screen bg-cover bg-center",style:{"background-image":"url('/images/popcorn.jpg')"}},U={class:"w-full max-w-md p-8 bg-white bg-opacity-90 shadow-lg rounded-lg"},D={key:0,class:"mb-4 text-sm font-medium text-green-600 text-center"},E={class:"mb-4"},R={class:"mb-4"},z={class:"mb-4 flex items-center justify-between"},A={class:"flex items-center"},F={__name:"Login",props:{canResetPassword:{type:Boolean},status:{type:String}},setup(l){const s=k({email:"",password:"",remember:!1}),i=()=>{s.post(route("login"),{onFinish:()=>s.reset("password")})};return(u,e)=>(n(),c(S,null,{default:d(()=>[a(t(V),{title:"Log in"}),o("div",N,[o("div",U,[e[6]||(e[6]=o("div",{class:"flex justify-center mb-6"},[o("img",{src:"/images/logo.png",alt:"Logo",class:"h-12 w-auto"})],-1)),l.status?(n(),v("div",D,B(l.status),1)):p("",!0),o("form",{onSubmit:C(i,["prevent"])},[o("div",E,[a(b,{for:"email",value:"Email"}),a(g,{id:"email",type:"email",class:"mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out",modelValue:t(s).email,"onUpdate:modelValue":e[0]||(e[0]=r=>t(s).email=r),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(w,{class:"mt-2",message:t(s).errors.email},null,8,["message"])]),o("div",R,[a(b,{for:"password",value:"Mot de passe"}),a(g,{id:"password",type:"password",class:"mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out",modelValue:t(s).password,"onUpdate:modelValue":e[1]||(e[1]=r=>t(s).password=r),required:"",autocomplete:"current-password"},null,8,["modelValue"]),a(w,{class:"mt-2",message:t(s).errors.password},null,8,["message"])]),o("div",z,[o("label",A,[a(M,{name:"remember",checked:t(s).remember,"onUpdate:checked":e[2]||(e[2]=r=>t(s).remember=r)},null,8,["checked"]),e[3]||(e[3]=o("span",{class:"ml-2 text-sm text-gray-600"},"Se souvenir de moi",-1))]),l.canResetPassword?(n(),c(t(P),{key:0,href:u.route("password.request"),class:"text-sm text-blue-500 hover:underline"},{default:d(()=>e[4]||(e[4]=[f(" Mot de passe oublié ? ")])),_:1},8,["href"])):p("",!0)]),o("div",null,[a(j,{class:$(["w-full bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out",{"opacity-25":t(s).processing}]),disabled:t(s).processing},{default:d(()=>e[5]||(e[5]=[f(" Se connecter ")])),_:1},8,["class","disabled"])])],32)])])]),_:1}))}},Q=q(F,[["__scopeId","data-v-74bc27bb"]]);export{Q as default};

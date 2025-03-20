import{k as m,C as _,f as i,b as a,a as e,u as r,w as c,T as v,e as y,o as w,d as g,g as V}from"./app-UflIzx5p.js";import{a as l,b as n,_ as d}from"./TextInput-D9-IPhIL.js";import{P as x}from"./PrimaryButton-CyGQfHPb.js";/* empty css            */import"./_plugin-vue_export-helper-DlAUqK2U.js";const P={class:"flex items-center gap-4"},k={key:0,class:"text-sm text-gray-600"},E={__name:"UpdatePasswordForm",setup(b){const u=m(null),p=m(null),s=_({current_password:"",password:"",password_confirmation:""}),f=()=>{s.put(route("password.update"),{preserveScroll:!0,onSuccess:()=>s.reset(),onError:()=>{s.errors.password&&(s.reset("password","password_confirmation"),u.value.focus()),s.errors.current_password&&(s.reset("current_password"),p.value.focus())}})};return(S,o)=>(w(),i("section",null,[o[4]||(o[4]=a("header",null,[a("h2",{class:"text-lg font-medium text-gray-900"}," Update Password "),a("p",{class:"mt-1 text-sm text-gray-600"}," Ensure your account is using a long, random password to stay secure. ")],-1)),a("form",{onSubmit:y(f,["prevent"]),class:"mt-6 space-y-6"},[a("div",null,[e(d,{for:"current_password",value:"Current Password"}),e(l,{id:"current_password",ref_key:"currentPasswordInput",ref:p,modelValue:r(s).current_password,"onUpdate:modelValue":o[0]||(o[0]=t=>r(s).current_password=t),type:"password",class:"mt-1 block w-full",autocomplete:"current-password"},null,8,["modelValue"]),e(n,{message:r(s).errors.current_password,class:"mt-2"},null,8,["message"])]),a("div",null,[e(d,{for:"password",value:"New Password"}),e(l,{id:"password",ref_key:"passwordInput",ref:u,modelValue:r(s).password,"onUpdate:modelValue":o[1]||(o[1]=t=>r(s).password=t),type:"password",class:"mt-1 block w-full",autocomplete:"new-password"},null,8,["modelValue"]),e(n,{message:r(s).errors.password,class:"mt-2"},null,8,["message"])]),a("div",null,[e(d,{for:"password_confirmation",value:"Confirm Password"}),e(l,{id:"password_confirmation",modelValue:r(s).password_confirmation,"onUpdate:modelValue":o[2]||(o[2]=t=>r(s).password_confirmation=t),type:"password",class:"mt-1 block w-full",autocomplete:"new-password"},null,8,["modelValue"]),e(n,{message:r(s).errors.password_confirmation,class:"mt-2"},null,8,["message"])]),a("div",P,[e(x,{disabled:r(s).processing},{default:c(()=>o[3]||(o[3]=[g("Save")])),_:1},8,["disabled"]),e(v,{"enter-active-class":"transition ease-in-out","enter-from-class":"opacity-0","leave-active-class":"transition ease-in-out","leave-to-class":"opacity-0"},{default:c(()=>[r(s).recentlySuccessful?(w(),i("p",k," Saved. ")):V("",!0)]),_:1})])],32)]))}};export{E as default};

const week = ['日', '月', '火', '水', '木', '金', '土']
//セレクトボックスを取得
const datelist = document.getElementById('datelist')
const end = 7

if(end !== undefined){

    for(let i = 0; i < end; i++){
        //取得する日付の値を設定
        let param = Date.now() + i * 86400000
        //値から日付を取得
        let date = new Date(param)
        
        //dateから年を取得
        let y = date.getFullYear()
        //dateから月を取得
        let m = date.getMonth()+1
        //dateから日を取得
        let d = date.getDate()
        //dateから曜日を取得
        let w = date.getDay()
        
        //月を2桁に揃える
        if(m < 10){ m = '0'+m }
        //日を2桁に揃える
        if(d < 10){ d = '0'+d }
        
        //テキストの出力形式
        let textFormat = y+'年'+m+'月'+d+'日'+'('+week[w]+')'
        //値の出力形式
        let valueFormat = y+'-'+m+'-'+d
        
        //option要素を作成
        let option = document.createElement('option')
        //optionのテキストを指定
        option.textContent = textFormat
        //optionの値を指定
        option.value = valueFormat
        //detelistの末尾に追加
        datelist.appendChild(option);
    }
}
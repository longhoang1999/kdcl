<style>
    .font-weight-bold{
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
    }
</style>
<div class="col-md-4">
    <div class="">
        <div class="pageHomeView">
            <h3>@lang('project/Externalreview/title.minhchung')</h3>
            <table class=" table m-t-md MC_Tc_Tchi">

                <tbody class="body_table">
                    
                </tbody>
            </table>

          

         
        </div>
    </div>
</div>
<!-- Minh chứng -> người tạo -> đơn vị -> tên ngắn đơn vị -->
<script type="text/javascript">
    let michChungObject = [];
    let nodeList = document.querySelectorAll(".danMinhChung");
    for(let i = 0; i < nodeList.length; i++){
        let object = {
            name: nodeList[i].textContent, 
            id: nodeList[i].getAttribute('d-id')
        }
        michChungObject.push(object)
    }
    // delete Duplicates object
    const uniqueArray = michChungObject.filter((value, index) => {
        const _value = JSON.stringify(value);
        return index === michChungObject.findIndex(obj => {
            return JSON.stringify(obj) === _value;
        });
    });
    

    let routeApi = "{{ route('admin.danhgiangoai.baocaotudanhgia.dataMinhChung') }}";
    for(let i = 0; i < uniqueArray.length; i++){
        fetch(routeApi, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            method: 'POST',
            body: JSON.stringify(uniqueArray[i])
        })
            .then((response) => response.json())
            .then((data) => {
                let UI = ` 
                    <tr>
                        <td colspan="2">
                            <a class="mt-4 mb-4" d-type="mcGop" 
                                d-id="${uniqueArray[i].id}" target="_blank">
                                <span class="text-danger font-weight-bold">
                                    ${uniqueArray[i].name}
                                </span>   
                                <p class="text-truncate-2">
                                    ${data[0]} (${data[1]})
                                </p>
                            </a>
                        </td>
                    </tr>
                 `;
                $(".body_table").append(UI)
            })
    }

</script>
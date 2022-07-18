/*function loadData(){

    var xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 &&  this.status == 200){
                console.log(this.responseText)
                const getData = JSON.parse(this.responseText)
                const totalReport = getData.TotalReports
                const totalFinished = getData.TotalFinished
                const totalOngoing = getData.TotalOngoing


                //Data from Database
                const totalKey = Object.keys(totalReport)
                const totalReportValue = Object.values(totalReport)
                const totalOngoingValue = Object.values(totalOngoing)
                const totalFinishedValue = Object.values(totalFinished)

                //Chart Configuration
                const data = {
                    labels: totalKey,
                    datasets: [
                        {
                            label: 'Total Number of Ongoing Reports',
                            data: totalOngoingValue,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)'
                            ],
                            borderColor:[
                                'rgb(255, 99, 132)'

                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'Total Number of Finished Reports',
                            data: totalFinishedValue,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)'
                            ],
                            borderColor:[
                                'rgb(75, 192, 192)'

                            ],
                            borderWidth: 1
                        }
                    ]
                }
                const config = {
                    type: 'bar',
                    data:data,
                    options: {
                        scales: {
                            y: {
                                suggestedMax: 15,
                                beginAtZero: true
                            }
                        }
                    }
                }
                const reportChart = new Chart(document.getElementById('totalReport'),config)

                When selection has been change
                const sortBy = document.getElementById('sortBy')
                sortBy.addEventListener('change',function(){
                    const sortValue = this.value
                    if(sortValue === 'Month'){
                        reportChart.data.labels = monthKeys
                        reportChart.data.datasets[0].data = monthValues
                        reportChart.update()
                    }
                    else{
                        reportChart.data.labels = dayKeys
                        reportChart.data.datasets[0].data = dayValues
                        reportChart.update()
                    }
                })

            }
    }
    xhttp.open('POST','../process/chartData.php',true);
    xhttp.send()
}
loadData()

*/


$(document).ready(function(){
    $.ajax({
        url: '../process/analytics.php',
        method: 'GET',
        success: function(data){
            loadData(data)
            printChart(data)
            
            var monthWithYear = Object.keys(data.total['incident']);
            dropDown(monthWithYear)
            
        }
    })
    
    var dropDown = function(data){
        $.each(data, function(key, value) {
            $('#selectDate')
                .append($('<option>', { value : value })
                .text(value))
        })
    }
    
    var printChart = function(data){
        
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
            var dt = new Date()
            var currentMonth = months[dt.getMonth()] +' '+dt.getFullYear()
            
            const monthlyIncident = data.total['incident'][currentMonth]
            const monthlyWaste = data.total['waste'][currentMonth]
            const monthlyInfra = data.total['infra'][currentMonth]
            
            $('#titleDate').html(currentMonth)
            
            const monthly = [monthlyIncident,monthlyWaste,monthlyInfra]
            
            const datas = {
                labels: ['Crime','Waste','Infrastructure'],
                datasets:[{
                    label: currentMonth,
                    data: monthly,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor:[
                        'rgb(255, 99, 132)',
                        'rgb(75, 192, 192)',
                        'rgba(54, 162, 235)'
                    ],
                    borderWidth: 1
                }]
            }
            
            const config = {
                type: 'bar',
                data:datas,
                options: {
                    plugins:{
                      legend:{
                          display: false
                      }  
                    },
                    scales:{
                        y:{
                            beginAtZero:  true,
                            suggestedMax: 10,
                            ticks:{
                                precision: 0
                            }
                        }
                    }
                }
            }
            
            const chartPrint = new Chart(document.getElementById('monthlyReport'),config)
            
        
        $('#selectDate').change(function(){
            var selected = $(this).val()
            
            $('#titleDate').html(selected)
            
            const monthlyIncident = data.total['incident'][selected]
            const monthlyWaste = data.total['waste'][selected]
            const monthlyInfra = data.total['infra'][selected]
            
            const monthly = [monthlyIncident,monthlyWaste,monthlyInfra]
            console.log(monthly)
            
            chartPrint.data.datasets[0].label = selected
            chartPrint.data.datasets[0].data = monthly
            chartPrint.update()
        })
    }
    
    var loadData = function(data){
        
        const monthlyIncident = data.total['incident']
        const monthlyWaste = data.total['waste']
        const monthlyInfra = data.total['infra']
        
        const incidentLabel = Object.keys(monthlyIncident)
        const wasteLabel = Object.keys(monthlyWaste)
        const infraLabel = Object.keys(monthlyInfra)
        
        const incidentValue = Object.values(monthlyIncident)
        const wasteValue = Object.values(monthlyWaste)
        const infraValue = Object.values(monthlyInfra)

        const datas = {
            labels: incidentLabel,
            datasets: [{
                label: 'Crime',
                data: incidentValue,
                fill: false,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            },
            {
                label: 'Waste',
                data: wasteValue,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            },
            {
                label: 'Infrastructure',
                data: infraValue,
                fill: false,
                borderColor: 'rgb(54, 162, 235)',
                tension: 0.1
            }]
        }
        
        const config = {
            type: 'line',
            data:datas,
            options:{
                scales:{
                    y:{
                        beginAtZero: true,
                        suggestedMax: 10,
                        ticks:{
                            precision: 0
                        }
                    }
                }
            }
        }
        
        const chart = new Chart(document.getElementById('totalReport'),config)
    }
})


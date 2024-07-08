try{
    var options = {
  
  
      
      chart: {
          height:80,
          animations: {
              enabled: false
          },
          sparkline: {
              enabled: true
          },
          dropShadow: {
            enabled: true,
            top: 12,
            left: 0,
            bottom: 0,
            right: 0,
            blur: 2,
            color: "rgba(132, 145, 183, 0.3)",
            opacity: 0.35,
          },
          type:"bar"
      },
      plotOptions: {
          bar: {
              horizontal: false, 
              endingShape: "rounded", 
              columnWidth: "40%"
          }
      },
      dataLabels: {
          enabled: false
      },
      stroke: {
          show: true, 
          width: 2, 
          colors: ["transparent"]
      },
      colors: ["#5C3DC3"],
      series:[ {
          name: "Orders", 
          data: [50, 60, 70, 80, 90, 100, 95, 85, 75, 65, 55, 65, 75, 85, 95, 105, 80, 70, 60, 50, 40, 30, 45, 55, 65, 75, 85, 95, 100, 80, 60]
      }
      ],
      xaxis: {
          categories: ['1-Jan','2-Jan','3-Jan','4-Jan','5-Jan','6-Jan','7-Jan','8-Jan','9-Jan','10-Jan','11-Jan','12-Jan','13-Jan','14-Jan','15-Jan','16-Jan','17-Jan','18-Jan','19-Jan','20-Jan','21-Jan','22-Jan','23-Jan','24-Jan','25-Jan','26-Jan','27-Jan','28-Jan','29-Jan','30-Jan','31-Jan'],
          crosshairs: {
              show: false,
          },
      },
      fill: {
          opacity: 0.9
      },
      
      tooltip: {
          y: {
              formatter:function(val) {
                  return" "+val+" "
              },
          },
      }
  
   }
  var chart = new ApexCharts(
      document.querySelector("#apex_column1"),
      options
    );
  
    chart.render();
  }catch(err){}
  
  
  try{
    var dash_spark_1 = {
      
      chart: {
          type: 'area',
          height: 80,
          sparkline: {
              enabled: true
          },
          dropShadow: {
            enabled: true,
            top: 12,
            left: 0,
            bottom: 0,
            right: 0,
            blur: 2,
            color: "rgba(132, 145, 183, 0.3)",
            opacity: 0.35,
          },
      },
      stroke: {
          curve: 'smooth',
          width: 1
        },
      fill: {
          opacity: 0.05,
      },
      series: [{
        data: [4, 8, 5, 10, 4, 16, 5, 11, 6, 11, 30, 10, 13, 4, 6, 3, 6]
      }],
      yaxis: {
          min: 0
      },
      colors: ['#00be82'],
    }
    new ApexCharts(document.querySelector("#dash_spark_1"), dash_spark_1).render();
  }catch (err){}
  
  try{
  var options = {
    chart: {
      height: 100,
      type: "donut",
      dropShadow: {
        enabled: true,
        top: 12,
        left: 0,
        bottom: 0,
        right: 0,
        blur: 2,
        color: "rgba(132, 145, 183, 0.3)",
        opacity: 0.35,
      },
    },
    plotOptions: {
      pie: {
        donut: {
          size: "75%",
        },
      },
    },
    dataLabels: {
      enabled: false,
    },
  
    stroke: {
      show: true,
      width: 2,
      colors: ["transparent"],
    },
  
    series: [50, 25, 25],
    legend: {
      show: false,
      position: "right",
      horizontalAlign: "center",
      verticalAlign: "middle",
      floating: false,
      fontSize: "13px",
      offsetX: 0,
      offsetY: 0,
    },
    labels: ["Mobile", "Tablet", "Desktop"],
    colors: ["#fd3d97", "#5d78ff", "#35bfa3"],
  
    responsive: [
      {
        breakpoint: 600,
        options: {
          plotOptions: {
            donut: {
              customScale: 0.2,
            },
          },
          chart: {
            height: 240,
          },
          legend: {
            show: false,
          },
        },
      },
    ],
    tooltip: {
      y: {
        formatter: function (val) {
          return val + " %";
        },
      },
    },
  };
  
  var chart = new ApexCharts(document.querySelector("#ana_device"), options);
  chart.render();
  
  }catch (err) {}
  
  try{
    var options = {
      chart: {
          height: 350,
          type: 'area',
          width: '100%',
          stacked: true,
          toolbar: {
            show: false,
            autoSelected: 'zoom'
          },
          dropShadow: {
            enabled: true,
            top: 12,
            left: 0,
            bottom: 0,
            right: 0,
            blur: 2,
            color: "rgba(132, 145, 183, 0.3)",
            opacity: 0.35,
          },
      },
      colors: ['#1b1b22', '#fa6432'],
      dataLabels: {
          enabled: false
      },
      stroke: {
          curve: 'straight',
          width: [2, 0.5],
          dashArray: [0, 3],
          lineCap: 'round',
      },
      grid: {
        padding: {
          left: 0,
          right: 0
        },
        strokeDashArray: 3,
      },
      markers: {
        size: 0,
        hover: {
          size: 0
        }
      },
      series: [{
          name: 'Last Year',
          data: [0,60,20,90,45,110,55,130,44,110,75,120]
      }, {
          name: 'This Year',
          data: [0,45,10,75,35,94,40,115,30,105,65,110]
      }],
    
      xaxis: {
          type: 'month',
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          axisBorder: {
            show: true,
          },  
          axisTicks: {
            show: true,
          },                  
      },
      fill: {
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.4,
          opacityTo: 0.1,
          stops: [0, 90, 100]
        }
      },
      
      tooltip: {
          x: {
              format: 'dd/MM/yy HH:mm'
          },
      },
      legend: {
        position: 'top',
        horizontalAlign: 'right'
      },
    }
    
    var chart = new ApexCharts(
      document.querySelector("#crm-dash"),
      options
    );
    
    chart.render();
    
    }catch (err) {}
  
  
    try{
      var options = {
        chart: {
            height: 205,
            type: 'donut',
        }, 
        plotOptions: {
          pie: {
            donut: {
              size: '85%'
            }
          }
        },
        dataLabels: {
          enabled: false,
          },
          stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
       
        series: [10, 65, 25,],
        legend: {
            show: false,
            position: 'bottom',
            horizontalAlign: 'center',
            verticalAlign: 'middle',
            floating: false,
            fontSize: '14px',
            offsetX: 0,
            offsetY: 5
        },
        labels: [ "Mobile", "Tablet", "Desktop"],
        colors: ["#13939c", "#603dc3", "#fac639"],
       
        responsive: [{
            breakpoint: 600,
            options: {
              plotOptions: {
                  donut: {
                    customScale: 0.2
                  }
                },        
                chart: {
                    height: 200
                },
                legend: {
                    show: false
                },
            }
        }],
      
        tooltip: {
          y: {
              formatter: function (val) {
                  return   val + " %"
              }
          }
        }  
      }
      
      var chart = new ApexCharts(
        document.querySelector("#email_report"),
        options
      );
      
      chart.render();
    }catch(err){}
  
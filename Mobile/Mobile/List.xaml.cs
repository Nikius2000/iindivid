using Android.App;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace Mobile
{
    [XamlCompilation(XamlCompilationOptions.Compile)]

    public partial class List : ContentPage
    {
        public List()
        {
            InitializeComponent();
        }

        protected override void OnAppearing()
        {
            FetchDataFromApi();
        }

        async void OnTapped(object sender, EventArgs e)
        {
            var tappedStackLayout = (StackLayout)sender;
            var i_id = tappedStackLayout.ClassId;

            var httpClient = new HttpClient();
            var resultJson = await httpClient.GetStringAsync($"http://192.168.0.16/Visits/get.php/?id={i_id}");

            var resultVisit =
                JsonConvert.DeserializeObject<Public_Visits[]>(resultJson);

            


            bool result = await DisplayAlert(i_id,
                $"Имя: {resultVisit[0].i_name}\n" +
                $"Фамилия: {resultVisit[0].f_name}\n" +
                $"Отчество: {resultVisit[0].o_name}\n" +
                $"Номер телефона: {resultVisit[0].phone}\n" +
                $"Дата посещения: {resultVisit[0].date_start}\n" +
                $"Серия и номер паспорта: {resultVisit[0].ser_passport} {resultVisit[0].num_passport} \n" +
                $"Дата рождения: {resultVisit[0].date_age}",
                $"Пропустить", "Отказано");

            if(result == true)
            {

                HttpClient client = new HttpClient();
                string response = await client.GetStringAsync($"http://192.168.0.16/Visits/miss.php/?id={i_id}&miss=1");
                FetchDataFromApi();
                await DisplayAlert("Уведомление", "Вы пропустили человека на территорию", "OK");

            }
            else
            {
                HttpClient client = new HttpClient();
                string response = await client.GetStringAsync($"http://192.168.0.16/Visits/miss.php/?id={i_id}&miss=-1");
                FetchDataFromApi();
                await DisplayAlert("Уведомление", "Вы отказали человеку ", "OK");
            }
        }

        private async void FetchDataFromApi()
        {
            var httpClient = new HttpClient();
            var resultJson = await httpClient.GetStringAsync("http://192.168.0.16/Visits/get.php/?status=1&miss=0");

            var resultVisits =
                JsonConvert.DeserializeObject<Public_Visits[]>(resultJson);

            Visits.ItemsSource = resultVisits;
        }
    }
}
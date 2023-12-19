using Android.App;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using Xamarin.Forms;

namespace Mobile
{
    public partial class MainPage : ContentPage
    {
        public MainPage()
        {
            InitializeComponent();
        }

        private async void btn_login_Click(object sender, EventArgs e)
        {

            string login = _login.Text;
            string password = _password.Text;

            if (login == string.Empty || password == string.Empty)
            {
                err_result.Text = "Не все поля заполнены!";
            }
            else
            {
                var httpClient = new HttpClient();
                var resultJson = await httpClient.GetStringAsync($"http://192.168.0.16/Login/Security/?login={login}&password={password}");

                if(Convert.ToInt32(resultJson) > 0)
                {
                    err_result.Text = "Успешно!";
                    await DisplayAlert("Успешно!", "Вы вошли", "Окей");
                    await Navigation.PushAsync(new List());
                }
                else
                {
                    err_result.Text = "Логин или пароль не верный!";
                }
            }
        }
    }
}

using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace Security
{
    /// <summary>
    /// Логика взаимодействия для MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
        }

        private async void btn_login_Click(object sender, RoutedEventArgs e)
        {
            string login = inp_login.Text;
            string password = inp_password.Text;


            if (login != string.Empty || password != string.Empty)
            {

                if (login == string.Empty || password == string.Empty)
                {
                    MessageBox.Show("Не все поля заполнены!");
                }
                else
                {
                    var httpClient = new HttpClient();
                    var resultJson = await httpClient.GetStringAsync($"http://192.168.0.16/Login/Security/?login={login}&password={password}");

                    if (Convert.ToInt32(resultJson) > 0)
                    {
                        MessageBox.Show("Вы вошли!");

                        List list = new List();
                        list.Show();
                        this.Close();
                    }
                    else
                    {
                        MessageBox.Show("Логин или пароль не верный!");
                    }
                }
            }
            else
            {
                MessageBox.Show("Заполните все поля!");

            }
        }
    }
}

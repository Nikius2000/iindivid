using Newtonsoft.Json;
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
using System.Windows.Shapes;
using Security.Models;

namespace Security
{
    /// <summary>
    /// Логика взаимодействия для List.xaml
    /// </summary>
    public partial class List : Window
    {
        public List()
        {
            InitializeComponent();
            RefreshDataGrid();
        }
        private async void RefreshDataGrid()
        {
            var httpClient = new HttpClient();
            var resultJson = await httpClient.GetStringAsync($"http://192.168.0.16/Visits/get.php/?status=1");

            var resultVisit =
                JsonConvert.DeserializeObject<Public_Visits[]>(resultJson);
            DataGrid_list.ItemsSource = resultVisit;

        }

        private async void search_Click(object sender, RoutedEventArgs e)
        {

            var httpClient = new HttpClient();
            var resultJson = await httpClient.GetStringAsync($"http://192.168.0.16/Visits/get.php/?id={search_id.Text}");

            var resultVisit =
                JsonConvert.DeserializeObject<Public_Visits[]>(resultJson);

            string id = Convert.ToString(resultVisit[0].Id);
            string f_name = Convert.ToString(resultVisit[0].f_name);
            string i_name = Convert.ToString(resultVisit[0].i_name);
            string o_name = Convert.ToString(resultVisit[0].o_name);
            string status = Convert.ToString(resultVisit[0].status);
            string ser_passport = Convert.ToString(resultVisit[0].ser_passport);
            string num_passport = Convert.ToString(resultVisit[0].num_passport);

            inp_id.Text = id;
            inp_f_name.Text = f_name;
            inp_i_name.Text = i_name;
            inp_o_name.Text = o_name;
            inp_status.Text = status;
            inp_ser_passport.Text = ser_passport;
            inp_num_passport.Text = num_passport;

            RefreshDataGrid();

        }

        private async void btn_no_Click(object sender, RoutedEventArgs e)
        {

            string id = inp_id.Text;

            HttpClient client = new HttpClient();
            string response = await client.GetStringAsync($"http://192.168.0.16/Visits/edit.php/?id={id}&miss=-1");

            MessageBox.Show("Успешно!");
            RefreshDataGrid();
        }

        private async void btn_yes_Click(object sender, RoutedEventArgs e)
        {

            string id = inp_id.Text;

            var httpClient = new HttpClient();
            var resultJson = await httpClient.GetStringAsync($"http://192.168.0.16/Visits/delete.php/?id={id}&miss=1");

            MessageBox.Show("Успешно!");
            RefreshDataGrid();
        }
    }
}

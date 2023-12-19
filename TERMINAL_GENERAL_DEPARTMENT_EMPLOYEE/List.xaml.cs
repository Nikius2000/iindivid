using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
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
using TERMINAL_GENERAL_DEPARTMENT_EMPLOYEE.Models;

namespace TERMINAL_GENERAL_DEPARTMENT_EMPLOYEE
{
    /// <summary>
    /// Логика взаимодействия для MainWindow.xaml
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
            var resultJson = await httpClient.GetStringAsync($"http://192.168.0.16/Visits/get.php/?status=0");

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

            inp_id.Text = id;
            inp_f_name.Text = f_name;
            inp_i_name.Text = i_name;
            inp_o_name.Text = o_name;
            inp_status.Text = status;

            RefreshDataGrid();

        }

        private async void edit_Click(object sender, RoutedEventArgs e)
        {

            string id = inp_id.Text;
            string status = inp_status.Text;

            HttpClient client = new HttpClient();
            string response = await client.GetStringAsync($"http://192.168.0.16/Visits/edit.php/?id={id}&status={status}");

            RefreshDataGrid();
        }

        private async void delete_Click(object sender, RoutedEventArgs e)
        {
            string idToDelete = inp_id.Text;

            if (!string.IsNullOrEmpty(idToDelete))
            {

                var httpClient = new HttpClient();
                var resultJson = await httpClient.GetStringAsync($"http://192.168.0.16/Visits/delete.php/?id={idToDelete}");

                MessageBox.Show("Успешно!");
                inp_id.Text = "";
                inp_f_name.Text = "";
                inp_i_name.Text = "";
                inp_o_name.Text = "";
                inp_status.Text = "";
                RefreshDataGrid();

            }
            else { MessageBox.Show("Введите айди для удаления.");
            }
        }
    }
}

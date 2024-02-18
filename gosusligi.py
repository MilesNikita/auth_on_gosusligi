import requests
import schedule
import time
from bs4 import BeautifulSoup


cert_path = 'путь_к_сертификату.pem'
token = 'указать_токен'

def get_notifications():
    url = 'https://esia.gosuslugi.ru/'
    response = requests.get(url, cert=cert_path, headers={'Authorization': f'Bearer {token}'})
    if response.status_code == 200:
        print("Успешно получено количество уведомлений")
        soup = BeautifulSoup(response.text, 'html.parser')
        notifications = soup.find_all(class_='notification')
        print(f"Количество уведомлений на госуслугах: {len(notifications)}")
    else:
        print("Ошибка при получении уведомлений. Код ошибки:", response.status_code)

schedule.every().hour.do(get_notifications)
while True:
    schedule.run_pending()
    time.sleep(1)

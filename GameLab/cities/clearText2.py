import json

# Читаем ваш текущий файл
with open("cities/old_file.json", 'r', encoding='utf-8') as f:
    data = json.load(f)  # 'data' теперь — это ваш словарь с ключом "city"

# Извлекаем только значения "name"
# (Проходим по списку внутри ключа "city")
city_names = [item["name"] for item in data["city"]]

# Сохраняем "чистый" список для JS
with open('cities.json', 'w', encoding='utf-8') as f:
    json.dump(city_names, f, ensure_ascii=False)
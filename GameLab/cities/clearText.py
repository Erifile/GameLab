filename = "cities.json"

# 1. Читаем все строки
with open(filename, "r", encoding="utf-8") as f:
    lines = f.readlines()

# 2. Фильтруем (например, удаляем строку, содержащую слово "ошибка")
# Оставляем только те строки, которые нам нужны
new_lines = [line for line in lines if '"city_id"' not in line and '"country_id"' not in line and '"region_id"' not in line]

# 3. Перезаписываем файл
with open(filename, "w", encoding="utf-8") as f:
    f.writelines(new_lines)
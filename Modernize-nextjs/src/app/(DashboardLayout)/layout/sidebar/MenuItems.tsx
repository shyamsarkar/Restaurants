import {
  IconAperture,
  IconLayoutDashboard,
  IconLogin,
} from "@tabler/icons-react";

import { uniqueId } from "lodash";

const Menuitems = [
  {
    id: uniqueId(),
    title: "Dashboard",
    icon: IconLayoutDashboard,
    href: "/",
  },
  {
    id: uniqueId(),
    title: "Billing",
    icon: IconAperture,
    href: "/billing",
  },
];

export default Menuitems;

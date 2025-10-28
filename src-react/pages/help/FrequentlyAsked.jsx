import React from "react";
import Container from "../../components/ui/Container";
export function FrequentlyAsked({color, description}) {
  const bgColor = {
    green: "bg-[#BEF264]"
  }
  
  return <Container className={`${bgColor[color]} rounded shadow snap-start max-w-[250px]`}>
                        <p>{description} </p>
                        </Container>;
}
  